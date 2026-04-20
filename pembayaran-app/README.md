# Sistem Pembayaran dan Penagihan

Aplikasi mini ERP kredit berbasis Laravel untuk mengelola nasabah, tagihan, approval, pembayaran, tunggakan, dashboard per role, dan export laporan.

## Fitur Utama

- Manajemen `Nasabah`, `Tagihan`, dan `Pembayaran`
- Role-based dashboard: `admin`, `kasir`, `marketing`
- Workflow approval tagihan (`pending`, `approved`, `rejected`)
- Validasi pembayaran:
  - tidak bisa bayar tagihan yang belum di-approve
  - tidak bisa overpayment
  - tidak bisa bayar tagihan yang sudah lunas
- Monitoring tunggakan + total tunggakan
- Export laporan pembayaran ke Excel (`/export/pembayaran`)

## Tech Stack

- PHP 8.2
- Laravel 12
- MySQL
- Blade + Tailwind CSS (Laravel Breeze)
- Laravel Excel (`maatwebsite/excel`)

## Demo Flow

Gunakan halaman `Demo Flow` di aplikasi, atau ikuti urutan ini:

1. Register / Login
2. Tambah Nasabah
3. Buat Tagihan
4. Approve Tagihan (Admin)
5. Input Pembayaran (Kasir/Admin)
6. Lihat Dashboard sesuai role
7. Export laporan pembayaran

## Akun Demo Seeder

- Admin: `admin@demo.com` / `password123`
- Kasir: `kasir@demo.com` / `password123`
- Marketing: `marketing@demo.com` / `password123`

## Cara Install

1. Install dependency:
   - `composer install`
   - `npm install`
2. Buat environment:
   - copy `.env.example` jadi `.env`
   - atur koneksi database MySQL
3. Generate app key:
   - `php artisan key:generate`
4. Migrasi + seed demo data:
   - `php artisan migrate:fresh --seed`
5. Jalankan aplikasi:
   - `php artisan serve`
   - `npm run dev`

## Catatan Export Excel

Untuk export `.xlsx`, PHP extension `zip` dan `gd` harus aktif pada environment.

## Screenshot

Tambahkan screenshot berikut untuk portfolio:

- Dashboard Admin
- Dashboard Kasir
- Dashboard Marketing
- Halaman Tunggakan
- Hasil export Excel
