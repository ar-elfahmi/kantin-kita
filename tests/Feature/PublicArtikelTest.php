<?php

namespace Tests\Feature;

use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtikelTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_published_articles(): void
    {
        Artikel::create([
            'judul' => 'Artikel Pertama Publik',
            'konten' => 'Konten artikel pertama yang dipublikasikan.',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_PUBLISHED,
        ]);

        $this->get('/artikel')
            ->assertOk()
            ->assertSee('Artikel Pertama Publik');
    }

    public function test_index_hides_draft_and_archived(): void
    {
        Artikel::create([
            'judul' => 'Draft Artikel Tersembunyi',
            'konten' => 'isi',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_DRAFT,
        ]);

        Artikel::create([
            'judul' => 'Arsip Artikel Tersembunyi',
            'konten' => 'isi',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_ARCHIVED,
        ]);

        $this->get('/artikel')
            ->assertOk()
            ->assertDontSee('Draft Artikel Tersembunyi')
            ->assertDontSee('Arsip Artikel Tersembunyi');
    }

    public function test_show_renders_full_konten_for_published(): void
    {
        $artikel = Artikel::create([
            'judul' => 'Artikel Lengkap',
            'ringkasan' => 'Ini adalah ringkasan pendek.',
            'konten' => 'Ini adalah konten lengkap artikel yang sangat panjang dan informatif.',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_PUBLISHED,
        ]);

        $this->get('/artikel/' . $artikel->slug)
            ->assertOk()
            ->assertSee('Artikel Lengkap')
            ->assertSee('Ini adalah konten lengkap artikel yang sangat panjang dan informatif.');
    }

    public function test_show_returns_404_for_draft(): void
    {
        $artikel = Artikel::create([
            'judul' => 'Draft Privat',
            'konten' => 'rahasia',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_DRAFT,
        ]);

        $this->get('/artikel/' . $artikel->slug)->assertNotFound();
    }

    public function test_show_returns_404_for_archived(): void
    {
        $artikel = Artikel::create([
            'judul' => 'Arsip Lama',
            'konten' => 'arsip',
            'kategori' => 'umum',
            'status' => Artikel::STATUS_ARCHIVED,
        ]);

        $this->get('/artikel/' . $artikel->slug)->assertNotFound();
    }

    public function test_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/artikel/slug-yang-tidak-ada')->assertNotFound();
    }

    public function test_landing_page_links_to_artikel_index(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('artikel.index'), false);
    }
}
