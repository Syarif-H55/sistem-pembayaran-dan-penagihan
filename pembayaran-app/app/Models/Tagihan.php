<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $appends = [
        'sisa_tagihan',
    ];

    protected $fillable = [
        'nasabah_id',
        'jumlah_tagihan',
        'jatuh_tempo',
        'status',
        'approval_status',
        'approved_by',
        'approved_at',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function refreshStatusFromPembayaran(): void
    {
        $totalBayar = $this->pembayaran()->sum('jumlah_bayar');

        $this->update([
            'status' => $totalBayar >= $this->jumlah_tagihan ? 'lunas' : 'belum_lunas',
        ]);
    }

    public function getSisaTagihanAttribute(): int
    {
        $totalBayar = (int) $this->pembayaran()->sum('jumlah_bayar');
        $sisa = (int) $this->jumlah_tagihan - $totalBayar;

        return max(0, $sisa);
    }
}
