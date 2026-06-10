<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class HomeController extends Controller
{
    public function index()
    {
        $tentangKamiArticles = Artikel::query()
            ->select('id', 'judul', 'slug', 'ringkasan', 'gambar_sampul', 'published_at')
            ->public()
            ->kategori(Artikel::KATEGORI_TENTANG_KAMI)
            ->orderByDesc('published_at')
            ->get();

        return view('welcome', [
            'tentangKamiArticles' => $tentangKamiArticles,
        ]);
    }
}
