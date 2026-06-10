<?php

namespace Tests\Feature;

use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_tentang_kami_article_is_visible(): void
    {
        Artikel::create([
            'judul' => 'About Article Visible',
            'slug' => 'about-article-visible',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi',
            'published_at' => now(),
        ]);

        $this->get('/')->assertSee('About Article Visible');
    }

    public function test_draft_article_is_hidden(): void
    {
        Artikel::create([
            'judul' => 'Draft Hidden Article',
            'slug' => 'draft-hidden-article',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'isi',
        ]);

        $this->get('/')->assertDontSee('Draft Hidden Article');
    }

    public function test_archived_article_is_hidden(): void
    {
        Artikel::create([
            'judul' => 'Archived Hidden Article',
            'slug' => 'archived-hidden-article',
            'kategori' => 'tentang-kami',
            'status' => 'archived',
            'konten' => 'isi',
            'published_at' => now(),
        ]);

        $this->get('/')->assertDontSee('Archived Hidden Article');
    }

    public function test_non_tentang_kami_category_is_hidden(): void
    {
        Artikel::create([
            'judul' => 'Berita Article',
            'slug' => 'berita-article',
            'kategori' => 'berita',
            'status' => 'published',
            'konten' => 'isi',
            'published_at' => now(),
        ]);

        $this->get('/')->assertDontSee('Berita Article');
    }

    public function test_articles_are_ordered_by_published_at_desc(): void
    {
        Artikel::create([
            'judul' => 'Older Article XYZZY',
            'slug' => 'older-article',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi',
            'published_at' => now()->subDays(10),
        ]);
        Artikel::create([
            'judul' => 'Newer Article QWERT',
            'slug' => 'newer-article',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi',
            'published_at' => now()->subDay(),
        ]);

        $body = $this->get('/')->getContent();

        $newerPos = strpos($body, 'Newer Article QWERT');
        $olderPos = strpos($body, 'Older Article XYZZY');

        $this->assertNotFalse($newerPos);
        $this->assertNotFalse($olderPos);
        $this->assertLessThan($olderPos, $newerPos);
    }

    public function test_empty_state_omits_section(): void
    {
        $this->get('/')->assertOk()->assertDontSee('Tentang Kami');
    }
}
