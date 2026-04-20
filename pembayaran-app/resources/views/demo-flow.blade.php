<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Demo Flow
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Alur Demo Sistem Pembayaran & Penagihan</h1>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                        Gunakan alur ini saat presentasi agar flow bisnis mudah dipahami.
                    </p>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li>Register atau login sesuai role (admin, kasir, marketing).</li>
                        <li>Tambah data nasabah baru.</li>
                        <li>Buat tagihan untuk nasabah.</li>
                        <li>Admin melakukan approve tagihan.</li>
                        <li>Kasir input pembayaran.</li>
                        <li>Lihat dashboard role-based untuk monitoring.</li>
                        <li>Export laporan pembayaran ke Excel.</li>
                    </ol>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Akun Demo Seeder</h3>
                    <p>Admin: <code>admin@demo.com</code> / <code>password123</code></p>
                    <p>Kasir: <code>kasir@demo.com</code> / <code>password123</code></p>
                    <p>Marketing: <code>marketing@demo.com</code> / <code>password123</code></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
