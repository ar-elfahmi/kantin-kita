<?php

namespace App\Http\Controllers;

use App\Models\KunjunganToko;
use App\Models\LokasiToko;
use App\Models\Vendor;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KunjunganTokoController extends Controller
{
    /**
     * Base radius in meters within which a sales visit is considered valid.
     * The effective threshold adds toko + sales accuracy on top (modul Lampiran 3).
     */
    private const THRESHOLD_METER = 300;

    /**
     * Earth radius in meters used by the Haversine formula (modul Lampiran 2).
     */
    private const EARTH_RADIUS_METER = 6_371_000;

    public function index()
    {
        $vendor = $this->guardVendor();

        $tokos = LokasiToko::query()
            ->where('vendor_id', $vendor->id)
            ->latest('updated_at')
            ->get();

        $kunjungans = KunjunganToko::query()
            ->where('vendor_id', $vendor->id)
            ->with('lokasiToko')
            ->latest()
            ->take(50)
            ->get();

        return view('vendor.kunjungan.index', [
            'vendor' => $vendor,
            'tokos' => $tokos,
            'kunjungans' => $kunjungans,
            'threshold' => self::THRESHOLD_METER,
        ]);
    }

    public function tokoCreate()
    {
        $vendor = $this->guardVendor();

        return view('vendor.kunjungan.toko-create', [
            'vendor' => $vendor,
        ]);
    }

    public function tokoStore(Request $request)
    {
        $vendor = $this->guardVendor();

        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:50'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['required', 'numeric', 'min:0', 'max:100000'],
        ]);

        $toko = LokasiToko::create([
            'vendor_id' => $vendor->id,
            'nama_toko' => $validated['nama_toko'],
            'latitude' => (float) $validated['latitude'],
            'longitude' => (float) $validated['longitude'],
            'accuracy' => (float) $validated['accuracy'],
        ]);

        return redirect()
            ->route('dashboard.kunjungan.index')
            ->with('kunjunganSuccess', "Toko \"{$toko->nama_toko}\" terdaftar dengan barcode {$toko->barcode}.");
    }

    public function tokoQr(LokasiToko $lokasi_toko)
    {
        $vendor = $this->guardVendor();

        if ((int) $lokasi_toko->vendor_id !== (int) $vendor->id) {
            abort(403);
        }

        $qrResult = (new Builder(
            writer: new PngWriter(),
            data: $lokasi_toko->barcode,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 400,
            margin: 12,
        ))->build();

        return view('vendor.kunjungan.toko-qr', [
            'vendor' => $vendor,
            'toko' => $lokasi_toko,
            'qrDataUri' => $qrResult->getDataUri(),
        ]);
    }

    public function scan()
    {
        $vendor = $this->guardVendor();

        return view('vendor.kunjungan.scan', [
            'vendor' => $vendor,
            'user' => Auth::user(),
            'threshold' => self::THRESHOLD_METER,
        ]);
    }

    public function lookupToko(string $barcode): JsonResponse
    {
        $vendor = $this->guardVendor();

        $toko = LokasiToko::query()
            ->where('vendor_id', $vendor->id)
            ->where('barcode', $barcode)
            ->first();

        if (! $toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'barcode' => $toko->barcode,
            'nama_toko' => $toko->nama_toko,
            'latitude' => $toko->latitude,
            'longitude' => $toko->longitude,
            'accuracy' => $toko->accuracy,
        ]);
    }

    public function visitStore(Request $request): JsonResponse
    {
        $vendor = $this->guardVendor();

        $validated = $request->validate([
            'barcode' => ['required', 'string', 'size:8'],
            'sales_latitude' => ['required', 'numeric', 'between:-90,90'],
            'sales_longitude' => ['required', 'numeric', 'between:-180,180'],
            'sales_accuracy' => ['required', 'numeric', 'min:0', 'max:100000'],
        ]);

        $toko = LokasiToko::query()
            ->where('vendor_id', $vendor->id)
            ->where('barcode', $validated['barcode'])
            ->first();

        if (! $toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk vendor Anda.',
            ], 404);
        }

        $jarak = $this->haversine(
            (float) $toko->latitude,
            (float) $toko->longitude,
            (float) $validated['sales_latitude'],
            (float) $validated['sales_longitude'],
        );

        $thresholdEfektif = self::THRESHOLD_METER
            + (float) $toko->accuracy
            + (float) $validated['sales_accuracy'];

        $status = $jarak <= $thresholdEfektif ? 'accepted' : 'rejected';

        $kunjungan = KunjunganToko::create([
            'vendor_id' => $vendor->id,
            'user_id' => Auth::id(),
            'lokasi_toko_barcode' => $toko->barcode,
            'sales_latitude' => (float) $validated['sales_latitude'],
            'sales_longitude' => (float) $validated['sales_longitude'],
            'sales_accuracy' => (float) $validated['sales_accuracy'],
            'jarak_meter' => $jarak,
            'threshold_efektif' => $thresholdEfektif,
            'status' => $status,
        ]);

        return response()->json([
            'status' => $status,
            'kunjungan_id' => $kunjungan->id,
            'nama_toko' => $toko->nama_toko,
            'jarak_meter' => round($jarak, 2),
            'threshold_meter' => self::THRESHOLD_METER,
            'threshold_efektif' => round($thresholdEfektif, 2),
            'toko_accuracy' => $toko->accuracy,
            'sales_accuracy' => (float) $validated['sales_accuracy'],
            'message' => $status === 'accepted'
                ? 'Kunjungan diterima — Anda berada dalam radius toko.'
                : 'Kunjungan ditolak — jarak ke toko melebihi threshold efektif.',
        ]);
    }

    private function guardVendor(): Vendor
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        return $vendor;
    }

    /**
     * Haversine great-circle distance in meters.
     * Implements modul Lampiran 2.
     */
    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_METER * $c;
    }
}
