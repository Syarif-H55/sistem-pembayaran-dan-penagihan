<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Marketing
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Ringkasan Marketing</h1>
                    <p>Tagihan Belum Lunas: {{ number_format($tagihanBelumLunas->count()) }}</p>
                    <p>Total Tunggakan: Rp {{ number_format($totalTunggakan) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Daftar Nasabah</h3>
                    @forelse ($daftarNasabah as $nasabah)
                        <p>{{ $nasabah->nama }} - {{ $nasabah->nik }} - {{ $nasabah->no_hp }}</p>
                    @empty
                        <p>Belum ada data nasabah.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Daftar Tagihan</h3>
                    @forelse ($daftarTagihan as $tagihan)
                        <p>
                            #{{ $tagihan->id }} - {{ $tagihan->nasabah?->nama ?? 'Tanpa Nasabah' }} - Rp {{ number_format($tagihan->jumlah_tagihan) }} - {{ $tagihan->status }}
                        </p>
                    @empty
                        <p>Belum ada data tagihan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Tagihan Belum Lunas</h3>
                    @forelse ($tagihanBelumLunas as $tagihan)
                        <p>
                            #{{ $tagihan->id }} - {{ $tagihan->nasabah?->nama ?? 'Tanpa Nasabah' }} - Rp {{ number_format($tagihan->jumlah_tagihan) }}
                        </p>
                    @empty
                        <p>Tidak ada tagihan belum lunas.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3">Daftar Tunggakan</h3>
                    @forelse ($tunggakan as $t)
                        <p>
                            {{ $t->nasabah?->nama ?? 'Tanpa Nasabah' }} -
                            Rp {{ number_format($t->jumlah_tagihan) }} -
                            Jatuh Tempo: {{ $t->jatuh_tempo }} -
                            <span class="text-red-500 font-semibold">MENUNGGAK</span> -
                            {{ now()->diffInDays($t->jatuh_tempo) }} hari
                        </p>
                    @empty
                        <p>Tidak ada tunggakan saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
