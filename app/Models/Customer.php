<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'nama',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'kodepos',
        'foto_path',
    ];

    protected $hidden = [
        'foto_blob',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function hasBlobPhoto(): bool
    {
        return ! is_null($this->foto_blob);
    }

    public function hasPathPhoto(): bool
    {
        return ! empty($this->foto_path);
    }
}
