<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    public const KATEGORI_TENTANG_KAMI = 'tentang-kami';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar_sampul',
        'kategori',
        'status',
        'published_at',
        'author_id',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::creating(function (Artikel $artikel) {
            if (empty($artikel->slug) && ! empty($artikel->judul)) {
                $artikel->slug = self::generateUniqueSlug($artikel->judul);
            }

            if ($artikel->status === self::STATUS_PUBLISHED && empty($artikel->published_at)) {
                $artikel->published_at = now();
            }
        });

        static::updating(function (Artikel $artikel) {
            $statusChanged = $artikel->isDirty('status');
            $original = $artikel->getOriginal('status');
            $becamePublished = $statusChanged
                && $artikel->status === self::STATUS_PUBLISHED
                && $original !== self::STATUS_PUBLISHED;

            if ($becamePublished && empty($artikel->published_at)) {
                $artikel->published_at = now();
            }
        });
    }

    public static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul);
        if ($base === '') {
            $base = 'artikel';
        }

        $slug = $base;
        $suffix = 2;

        while (
            self::query()
                ->withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    public function scopePublic($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
