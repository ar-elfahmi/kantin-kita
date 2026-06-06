<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatbotController extends Controller
{
    private const FALLBACK_ERROR_MESSAGE = 'Maaf, aku belum bisa menjawab pertanyaan itu sekarang. Coba tanya menu terlaris, menu hemat, jam operasional, atau cara pesan.';

    public function respond(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:400'],
        ]);

        $prompt = trim($validated['prompt']);
        if ($prompt === '') {
            return response()->json([
                'message' => 'Pertanyaan tidak boleh kosong.',
            ], 422);
        }

        try {
            $geminiReply = $this->requestGeminiReply($prompt);
            if (is_string($geminiReply) && $geminiReply !== '') {
                return response()->json([
                    'result' => $geminiReply,
                ]);
            }

            return response()->json([
                'result' => $this->buildRuleBasedReply($prompt),
            ]);
        } catch (Throwable $exception) {
            Log::warning('Chatbot response failed', [
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'result' => self::FALLBACK_ERROR_MESSAGE,
            ]);
        }
    }

    private function buildRuleBasedReply(string $prompt): string
    {
        $normalizedPrompt = mb_strtolower($prompt);

        if ($this->containsAny($normalizedPrompt, ['halo', 'hai', 'hello', 'hi'])) {
            return "Halo! Aku asisten Kantin Kita.\n"
                . "Kamu bisa tanya:\n"
                . "- menu terlaris\n"
                . "- menu di bawah 20 ribu\n"
                . "- jam operasional\n"
                . "- cara pesan tanpa antre";
        }

        if ($this->containsAny($normalizedPrompt, ['menu terlaris', 'bestseller', 'paling laku', 'terpopuler'])) {
            return $this->buildTopMenuReply();
        }

        if ($this->containsAny($normalizedPrompt, ['20 ribu', 'hemat', 'murah', 'budget', 'di bawah'])) {
            return $this->buildAffordableMenuReply();
        }

        if ($this->containsAny($normalizedPrompt, ['pedas', 'geprek', 'sambal'])) {
            return $this->buildSpicyMenuReply();
        }

        if ($this->containsAny($normalizedPrompt, ['jam', 'operasional', 'buka', 'tutup'])) {
            return $this->buildOperationalReply();
        }

        if ($this->containsAny($normalizedPrompt, ['cara pesan', 'checkout', 'antre', 'antri', 'order'])) {
            return "Cara pesan tanpa antre di Kantin Kita:\n"
                . "1. Pilih vendor dan menu yang diinginkan.\n"
                . "2. Atur jumlah pesanan lalu lanjut checkout.\n"
                . "3. Pilih metode pembayaran cashless.\n"
                . "4. Datang sesuai estimasi waktu ambil.\n"
                . "5. Tunjukkan detail pesanan ke vendor.";
        }

        if ($this->containsAny($normalizedPrompt, ['bayar', 'pembayaran', 'cashless', 'e-wallet', 'qris'])) {
            return "Pembayaran di Kantin Kita mendukung opsi cashless melalui gateway Midtrans.\n"
                . "Kamu bisa lanjutkan checkout untuk melihat metode paling nyaman (misalnya e-wallet, transfer, atau virtual account).";
        }

        return "Aku siap bantu kebutuhan makan siangmu.\n"
            . "Coba tanya salah satu ini:\n"
            . "- 'Menu terlaris hari ini apa?'\n"
            . "- 'Ada rekomendasi menu hemat?'\n"
            . "- 'Jam operasional kantin berapa?'\n"
            . "- 'Bagaimana cara pesan tanpa antre?'";
    }

    private function buildTopMenuReply(): string
    {
        $menus = Menu::query()
            ->select('menus.id', 'menus.nama_menu', 'menus.harga')
            ->selectRaw('COALESCE(SUM(detail_pesanans.jumlah), 0) AS total_ordered')
            ->leftJoin('detail_pesanans', 'detail_pesanans.menu_id', '=', 'menus.id')
            ->where('menus.is_available', true)
            ->groupBy('menus.id', 'menus.nama_menu', 'menus.harga')
            ->orderByDesc('total_ordered')
            ->orderBy('menus.nama_menu')
            ->limit(3)
            ->get();

        if ($menus->isEmpty()) {
            return 'Saat ini data menu terlaris belum tersedia. Coba cek halaman menu untuk melihat pilihan terbaru dari tiap vendor.';
        }

        $menuList = $menus
            ->map(function ($menu, int $index): string {
                return ($index + 1) . '. ' . $menu->nama_menu . ' (' . $this->formatRupiah((int) $menu->harga) . ')';
            })
            ->implode("\n");

        return "Ini menu yang paling sering dipesan saat ini:\n"
            . $menuList
            . "\n\nMau aku bantu pilihkan yang cocok untuk budgetmu?";
    }

    private function buildAffordableMenuReply(): string
    {
        $menus = Menu::query()
            ->where('is_available', true)
            ->where('harga', '<=', 20000)
            ->orderBy('harga')
            ->limit(4)
            ->get(['nama_menu', 'harga']);

        if ($menus->isEmpty()) {
            return 'Belum ada menu di bawah Rp 20.000 yang tersedia sekarang. Kamu tetap bisa cek promo dari vendor untuk harga terbaik.';
        }

        $menuList = $menus
            ->map(function ($menu): string {
                return '- ' . $menu->nama_menu . ' (' . $this->formatRupiah((int) $menu->harga) . ')';
            })
            ->implode("\n");

        return "Rekomendasi menu hemat di bawah Rp 20.000:\n"
            . $menuList
            . "\n\nKalau mau, aku bisa lanjut rekomendasi yang pedas atau yang porsi kenyang.";
    }

    private function buildSpicyMenuReply(): string
    {
        $menus = Menu::query()
            ->where('is_available', true)
            ->where(function ($query) {
                $query->where('nama_menu', 'like', '%pedas%')
                    ->orWhere('nama_menu', 'like', '%geprek%')
                    ->orWhere('nama_menu', 'like', '%balado%')
                    ->orWhere('deskripsi', 'like', '%pedas%');
            })
            ->orderBy('harga')
            ->limit(3)
            ->get(['nama_menu', 'harga']);

        if ($menus->isEmpty()) {
            return 'Menu pedas belum banyak tersedia saat ini. Coba cek vendor yang sedang buka untuk opsi sambal terbaru.';
        }

        $menuList = $menus
            ->map(function ($menu): string {
                return '- ' . $menu->nama_menu . ' (' . $this->formatRupiah((int) $menu->harga) . ')';
            })
            ->implode("\n");

        return "Ini rekomendasi menu pedas buat kamu:\n"
            . $menuList
            . "\n\nKalau mau yang lebih ramah kantong, bilang saja 'menu pedas hemat'.";
    }

    private function buildOperationalReply(): string
    {
        $openVendors = Vendor::query()
            ->where('is_open', true)
            ->orderByDesc('rating')
            ->limit(3)
            ->get(['nama_vendor', 'lokasi', 'rating']);

        if ($openVendors->isEmpty()) {
            return 'Belum ada vendor yang terdeteksi buka saat ini. Secara umum, operasional kantin kampus biasanya mulai pukul 07.00 sampai 17.00.';
        }

        $vendorList = $openVendors
            ->map(function ($vendor): string {
                $rating = number_format((float) $vendor->rating, 1);
                $lokasi = $vendor->lokasi ? ' - ' . $vendor->lokasi : '';

                return '- ' . $vendor->nama_vendor . ' (rating ' . $rating . ')' . $lokasi;
            })
            ->implode("\n");

        return "Vendor yang sedang buka sekarang:\n"
            . $vendorList
            . "\n\nSilakan pilih vendor lalu lanjut pesan untuk hindari antre panjang.";
    }

    private function requestGeminiReply(string $prompt): ?string
    {
        $apiKey = env('GEMINI_API_KEY');
        if (! is_string($apiKey) || trim($apiKey) === '') {
            return null;
        }

        $finalPrompt = "Anda adalah asisten virtual untuk platform pemesanan makanan kampus bernama Kantin Kita. "
            . "Jawab dalam Bahasa Indonesia yang ramah, ringkas, dan praktis untuk mahasiswa/staf kampus. "
            . "Jika pertanyaan di luar konteks kantin, arahkan kembali ke topik menu, operasional, pembayaran, atau cara pesan. "
            . "Pertanyaan pengguna: {$prompt}";

        $response = Http::timeout(25)
            ->acceptJson()
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $finalPrompt],
                        ],
                    ],
                ],
            ]);

        if (! $response->ok()) {
            return null;
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
        if (! is_string($text) || trim($text) === '') {
            return null;
        }

        return trim($text);
    }

    private function containsAny(string $haystack, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if ($keyword !== '' && str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    private function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
