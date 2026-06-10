<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'kategori_menu_id',
        'nama_menu',
        'deskripsi',
        'harga',
        'path_gambar',
        'is_available',
        'id_barang',
    ];

    protected static function booted(): void
    {
        static::creating(function (Menu $menu) {
            if (empty($menu->id_barang)) {
                do {
                    $idBarang = strtoupper(Str::random(8));
                } while (static::where('id_barang', $idBarang)->exists());
                $menu->id_barang = $idBarang;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function kategoriMenu(): BelongsTo
    {
        return $this->belongsTo(KategoriMenu::class);
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(MenuVariant::class)->orderBy('urutan');
    }

    public function toppings(): HasMany
    {
        return $this->hasMany(MenuTopping::class)->orderBy('urutan');
    }
}
