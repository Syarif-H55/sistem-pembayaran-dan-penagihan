<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Ringkasan Sistem</h1>
                    <p class="mb-2">Total Nasabah: {{ number_format($totalNasabah) }}</p>
                    <p class="mb-2">Total Tagihan: Rp {{ number_format($totalTagihan) }}</p>
                    <p class="mb-2">Total Pembayaran: Rp {{ number_format($totalPembayaran) }}</p>
                    <p>Tagihan Belum Lunas: {{ number_format($belumLunas) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Nasabah Terbaru</h3>
                    @forelse ($daftarNasabah as $nasabah)
                        <p>{{ $nasabah->nama }} - {{ $nasabah->nik }}</p>
                    @empty
                        <p>Belum ada data nasabah.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Tagihan Terbaru</h3>
                    @forelse ($daftarTagihan as $tagihan)
                        <p>
                            #{{ $tagihan->id }} - {{ $tagihan->nasabah?->nama ?? 'Tanpa Nasabah' }} - Rp {{ number_format($tagihan->jumlah_tagihan) }} - {{ $tagihan->status }} - Approval: {{ $tagihan->approval_status ?? 'pending' }}
                        </p>
                        <div class="mb-3 flex gap-2">
                            <form method="POST" action="{{ route('tagihan.approve', $tagihan->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm bg-green-600 text-white rounded">
                                    Approve
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tagihan.reject', $tagihan->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded">
                                    Reject
                                </button>
                            </form>
                        </div>
                    @empty
                        <p>Belum ada data tagihan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Riwayat Pembayaran Terbaru</h3>
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
