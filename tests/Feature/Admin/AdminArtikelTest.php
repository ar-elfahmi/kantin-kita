<?php

namespace Tests\Feature\Admin;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminArtikelTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin-artikel@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }

    public function test_create_draft_does_not_set_published_at(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/artikel', [
            'judul' => 'Draft Article',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'isi',
        ]);

        $response->assertRedirect();
        $artikel = Artikel::query()->where('judul', 'Draft Article')->first();
        $this->assertNotNull($artikel);
        $this->assertNull($artikel->published_at);
        $this->assertEquals('draft-article', $artikel->slug);
    }

    public function test_publish_sets_published_at(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/artikel', [
            'judul' => 'Hello',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi',
        ]);

        $artikel = Artikel::query()->where('judul', 'Hello')->first();
        $this->assertNotNull($artikel->published_at);
    }

    public function test_republish_does_not_reset_published_at(): void
    {
        $admin = $this->admin();
        $artikel = Artikel::create([
            'judul' => 'Republished',
            'slug' => 'republished',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi',
            'published_at' => now()->subDays(5),
        ]);

        $original = $artikel->published_at->copy();

        $this->actingAs($admin)->put('/admin/artikel/' . $artikel->id, [
            'judul' => 'Republished',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'isi diperbarui',
        ]);

        $artikel->refresh();
        $this->assertEquals($original->timestamp, $artikel->published_at->timestamp);
    }

    public function test_archive_hides_from_landing_page(): void
    {
        $admin = $this->admin();
        $artikel = Artikel::create([
            'judul' => 'Visible',
            'slug' => 'visible',
            'kategori' => 'tentang-kami',
            'status' => 'published',
            'konten' => 'konten visible unique',
            'published_at' => now(),
        ]);

        $this->get('/')->assertSee('Visible');

        $this->actingAs($admin)->post('/admin/artikel/' . $artikel->id . '/archive')->assertRedirect();

        $this->get('/')->assertDontSee('Visible');
    }

    public function test_image_upload_and_replace_deletes_old(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/artikel', [
            'judul' => 'With Image',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'isi',
            'gambar_sampul' => UploadedFile::fake()->image('first.jpg'),
        ]);

        $artikel = Artikel::query()->where('judul', 'With Image')->first();
        $originalPath = $artikel->gambar_sampul;
        $this->assertNotNull($originalPath);
        Storage::disk('public')->assertExists($originalPath);

        $this->actingAs($admin)->put('/admin/artikel/' . $artikel->id, [
            'judul' => 'With Image',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'isi',
            'gambar_sampul' => UploadedFile::fake()->image('second.jpg'),
        ]);

        $artikel->refresh();
        Storage::disk('public')->assertMissing($originalPath);
        Storage::disk('public')->assertExists($artikel->gambar_sampul);
    }

    public function test_slug_collision_appends_suffix(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/artikel', [
            'judul' => 'Same Title',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'a',
        ]);

        $this->actingAs($admin)->post('/admin/artikel', [
            'judul' => 'Same Title',
            'kategori' => 'tentang-kami',
            'status' => 'draft',
            'konten' => 'b',
        ]);

        $slugs = Artikel::query()->where('judul', 'Same Title')->pluck('slug')->all();
        sort($slugs);
        $this->assertSame(['same-title', 'same-title-2'], $slugs);
    }
}
