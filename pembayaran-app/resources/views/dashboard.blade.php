<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

                    <p class="mb-2">Total Nasabah: {{ number_format($totalNasabah) }}</p>
                    <p class="mb-2">Total Tagihan: Rp {{ number_format($totalTagihan) }}</p>
                    <p class="mb-2">Total Pembayaran: Rp {{ number_format($totalPembayaran) }}</p>
                    <p class="mb-2">Tagihan Belum Lunas: {{ number_format($belumLunas) }}</p>
                    <p>Pembayaran Hari Ini: Rp {{ number_format($pembayaranHariIni) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
