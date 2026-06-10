<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::query()
            ->select('id', 'judul', 'slug', 'ringkasan', 'gambar_sampul', 'kategori', 'published_at')
            ->public()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('artikel.index', [
            'artikels' => $artikels,
        ]);
    }

    public function show(Artikel $artikel)
    {
        if ($artikel->status !== Artikel::STATUS_PUBLISHED) {
            abort(404);
        }

        $related = Artikel::query()
            ->select('id', 'judul', 'slug', 'ringkasan', 'gambar_sampul', 'published_at')
            ->public()
            ->where('id', '!=', $artikel->id)
            ->where('kategori', $artikel->kategori)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('artikel.show', [
            'artikel' => $artikel,
            'related' => $related,
        ]);
    }
}
