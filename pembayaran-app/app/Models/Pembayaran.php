<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'jumlah_bayar',
        'tanggal_bayar',
    ];

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $pembayaran) {
            $tagihan = Tagihan::find($pembayaran->tagihan_id);
            if (!$tagihan) {
                throw new \Exception('Tagihan tidak ditemukan');
            }

            if ($tagihan->approval_status !== 'approved') {
                throw new \Exception('Tagihan belum di-approve');
            }

            if ((int) $pembayaran->jumlah_bayar <= 0) {
                throw new \Exception('Jumlah bayar tidak valid');
            }

            $totalBayar = (int) $tagihan->pembayaran()->sum('jumlah_bayar');
            if ($totalBayar >= (int) $tagihan->jumlah_tagihan) {
                throw new \Exception('Tagihan sudah lunas');
            }

            $sisa = (int) $tagihan->jumlah_tagihan - $totalBayar;
            if ((int) $pembayaran->jumlah_bayar > $sisa) {
                throw new \Exception('Pembayaran melebihi sisa tagihan');
            }
        });

        static::saved(function (self $pembayaran) {
            $tagihan = $pembayaran->tagihan()->first();
            if ($tagihan) {
                $totalBayar = (int) $tagihan->pembayaran()->sum('jumlah_bayar');
                $totalBaru = $totalBayar;

                if ($totalBaru >= (int) $tagihan->jumlah_tagihan) {
                    $tagihan->update([
                        'status' => 'lunas',
                    ]);
                } else {
                    $tagihan->update([
                        'status' => 'belum_lunas',
                    ]);
                }
            }
        });

        static::deleted(function (self $pembayaran) {
            $tagihan = $pembayaran->tagihan()->first();
            if ($tagihan) {
                $tagihan->refreshStatusFromPembayaran();
            }
        });
    }
}
