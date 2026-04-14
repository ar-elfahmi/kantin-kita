<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'snap_token',
        'transaction_id',
        'payment_type',
        'gross_amount',
        'status',
        'paid_at',
        'midtrans_response',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'midtrans_response' => 'array',
        ];
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}
