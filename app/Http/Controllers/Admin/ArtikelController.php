<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArtikelController extends Controller
{
    private array $statuses = [Artikel::STATUS_DRAFT, Artikel::STATUS_PUBLISHED, Artikel::STATUS_ARCHIVED];

    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');

        $query = Artikel::query()->with('author');

        if (in_array($statusFilter, $this->statuses, true)) {
            $query->where('status', $statusFilter);
        }

        $artikels = $query->latest('updated_at')->paginate(15)->withQueryString();

        return view('admin.artikel.index', [
            'artikels' => $artikels,
            'statusFilter' => $statusFilter,
            'statuses' => $this->statuses,
        ]);
    }

    public function create()
    {
        return view('admin.artikel.create', [
            'statuses' => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        $payload = [
            'judul' => $data['judul'],
            'slug' => Artikel::generateUniqueSlug($data['judul']),
            'ringkasan' => $data['ringkasan'] ?? null,
            'konten' => $data['konten'],
            'kategori' => $data['kategori'],
            'status' => $data['status'],
            'author_id' => Auth::id(),
        ];

        if ($request->hasFile('gambar_sampul')) {
            $payload['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

        Artikel::create($payload);

        return redirect()->route('admin.artikel.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', [
            'artikel' => $artikel,
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, Artikel $artikel)
    {
        $data = $this->validatePayload($request, $artikel->id);

        $payload = [
            'judul' => $data['judul'],
            'ringkasan' => $data['ringkasan'] ?? null,
            'konten' => $data['konten'],
            'kategori' => $data['kategori'],
            'status' => $data['status'],
        ];

        if (! empty($data['slug']) && $data['slug'] !== $artikel->slug) {
            $payload['slug'] = Artikel::generateUniqueSlug($data['slug'], $artikel->id);
        }

        if ($request->hasFile('gambar_sampul')) {
            if ($artikel->gambar_sampul) {
                Storage::disk('public')->delete($artikel->gambar_sampul);
            }
            $payload['gambar_sampul'] = $request->file('gambar_sampul')->store('artikel', 'public');
        }

        $artikel->update($payload);

        return redirect()->route('admin.artikel.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('status', 'Artikel berhasil dihapus.');
    }

    public function archive(Artikel $artikel)
    {
        $artikel->update(['status' => Artikel::STATUS_ARCHIVED]);

        return redirect()->route('admin.artikel.index')->with('status', 'Artikel diarsipkan.');
    }

    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in($this->statuses)],
            'gambar_sampul' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
