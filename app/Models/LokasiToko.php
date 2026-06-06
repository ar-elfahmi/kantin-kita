<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LokasiToko extends Model
{
    use HasFactory;

    protected $table = 'lokasi_toko';

    protected $primaryKey = 'barcode';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'barcode',
        'vendor_id',
        'nama_toko',
        'latitude',
        'longitude',
        'accuracy',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'accuracy' => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (LokasiToko $toko) {
            if (empty($toko->barcode)) {
                do {
                    $code = strtoupper(Str::random(8));
                } while (static::query()->where('barcode', $code)->exists());
                $toko->barcode = $code;
            }
        });
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(KunjunganToko::class, 'lokasi_toko_barcode', 'barcode');
    }
}
