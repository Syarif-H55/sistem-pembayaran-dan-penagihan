<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            ['name' => 'Admin Demo', 'password' => Hash::make('password123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'kasir@demo.com'],
            ['name' => 'Kasir Demo', 'password' => Hash::make('password123'), 'role' => 'kasir']
        );

        User::updateOrCreate(
            ['email' => 'marketing@demo.com'],
            ['name' => 'Marketing Demo', 'password' => Hash::make('password123'), 'role' => 'marketing']
        );

        for ($i = 1; $i <= 8; $i++) {
            $nasabah = Nasabah::create([
                'nama' => "Nasabah {$i}",
                'nik' => '3201' . str_pad((string) random_int(1, 999999999999), 12, '0', STR_PAD_LEFT),
                'no_hp' => '08' . random_int(1111111111, 9999999999),
                'alamat' => "Alamat Nasabah {$i}",
            ]);

            $tagihan = Tagihan::create([
                'nasabah_id' => $nasabah->id,
                'jumlah_tagihan' => random_int(150000, 700000),
                'jatuh_tempo' => now()->subDays(random_int(3, 20))->toDateString(),
                'status' => 'belum_lunas',
                'approval_status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(random_int(1, 5)),
            ]);

            if ($i <= 5) {
                $nominal = (int) floor($tagihan->jumlah_tagihan * 0.5);
                Pembayaran::create([
                    'tagihan_id' => $tagihan->id,
                    'jumlah_bayar' => $nominal,
                    'tanggal_bayar' => now()->subDays(random_int(0, 4))->toDateString(),
                ]);
            }

            if ($i <= 3) {
                $sisa = $tagihan->fresh()->sisa_tagihan;
                if ($sisa > 0) {
                    Pembayaran::create([
                        'tagihan_id' => $tagihan->id,
                        'jumlah_bayar' => $sisa,
                        'tanggal_bayar' => now()->toDateString(),
                    ]);
                }
            }
        }
    }
}
