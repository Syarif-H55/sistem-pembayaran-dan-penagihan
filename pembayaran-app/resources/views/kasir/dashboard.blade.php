<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Kasir
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Ringkasan Kasir</h1>
                    <p class="mb-2">Pembayaran Hari Ini: Rp {{ number_format($pembayaranHariIni) }}</p>
                    <p>
                        Akses cepat: <a class="underline" href="{{ route('pembayaran.create') }}">Input Pembayaran</a>
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Riwayat Pembayaran</h3>
                    @forelse ($riwayatPembayaran as $pembayaran)
                        <p>
                            #{{ $pembayaran->id }} - {{ $pembayaran->tagihan?->nasabah?->nama ?? 'Tanpa Nasabah' }} - Rp {{ number_format($pembayaran->jumlah_bayar) }} - {{ $pembayaran->tanggal_bayar }}
                        </p>
                    @empty
                        <p>Belum ada data pembayaran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
