<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuTopping extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'nama',
        'harga',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'urutan' => 'integer',
        ];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
