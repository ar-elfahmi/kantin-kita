<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $vendor = $this->guardVendor();

        $customers = Customer::query()
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->get();

        return view('vendor.customer.index', [
            'vendor' => $vendor,
            'customers' => $customers,
        ]);
    }

    public function createBlob()
    {
        $vendor = $this->guardVendor();

        return view('vendor.customer.create-blob', [
            'vendor' => $vendor,
        ]);
    }

    public function storeBlob(Request $request)
    {
        $vendor = $this->guardVendor();

        $validated = $this->validateCustomerInput($request);
        $bytes = $this->decodeDataUrl($validated['foto_data_url']);

        $customer = new Customer([
            'vendor_id' => $vendor->id,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'provinsi' => $validated['provinsi'],
            'kota' => $validated['kota'],
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'],
            'kodepos' => $validated['kodepos'],
        ]);
        $customer->foto_blob = $bytes;
        $customer->save();

        return redirect()
            ->route('dashboard.customer.index')
            ->with('customerSuccess', 'Customer berhasil ditambahkan (BLOB variant).');
    }

    public function createPath()
    {
        $vendor = $this->guardVendor();

        return view('vendor.customer.create-path', [
            'vendor' => $vendor,
        ]);
    }

    public function storePath(Request $request)
    {
        $vendor = $this->guardVendor();

        $validated = $this->validateCustomerInput($request);
        $bytes = $this->decodeDataUrl($validated['foto_data_url']);

        $relativePath = 'customers/' . Str::uuid()->toString() . '.png';
        Storage::disk('public')->put($relativePath, $bytes);

        Customer::create([
            'vendor_id' => $vendor->id,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'provinsi' => $validated['provinsi'],
            'kota' => $validated['kota'],
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'],
            'kodepos' => $validated['kodepos'],
            'foto_path' => $relativePath,
        ]);

        return redirect()
            ->route('dashboard.customer.index')
            ->with('customerSuccess', 'Customer berhasil ditambahkan (file path variant).');
    }

    public function photoBlob(Customer $customer): Response
    {
        $vendor = $this->guardVendor();

        if ((int) $customer->vendor_id !== (int) $vendor->id) {
            abort(403);
        }

        $bytes = DB::table('customers')
            ->where('id', $customer->id)
            ->value('foto_blob');

        if (! $bytes) {
            abort(404);
        }

        return response($bytes, 200, [
            'Content-Type' => 'image/png',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=3600',
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
     * @return array<string,string>
     */
    private function validateCustomerInput(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
            'provinsi' => ['required', 'string', 'max:100'],
            'kota' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kodepos' => ['required', 'string', 'max:10'],
            'foto_data_url' => ['required', 'string', 'regex:/^data:image\/png;base64,[A-Za-z0-9+\/=]+$/'],
        ]);
    }

    private function decodeDataUrl(string $dataUrl): string
    {
        $base64 = substr($dataUrl, strlen('data:image/png;base64,'));
        $bytes = base64_decode($base64, true);

        if ($bytes === false || $bytes === '') {
            abort(422, 'Data foto tidak valid.');
        }

        return $bytes;
    }
}
