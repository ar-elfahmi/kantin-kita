<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KunjunganToko extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_toko';

    protected $fillable = [
        'vendor_id',
        'user_id',
        'lokasi_toko_barcode',
        'sales_latitude',
        'sales_longitude',
        'sales_accuracy',
        'jarak_meter',
        'threshold_efektif',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sales_latitude' => 'float',
            'sales_longitude' => 'float',
            'sales_accuracy' => 'float',
            'jarak_meter' => 'float',
            'threshold_efektif' => 'float',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function lokasiToko(): BelongsTo
    {
        return $this->belongsTo(LokasiToko::class, 'lokasi_toko_barcode', 'barcode');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
