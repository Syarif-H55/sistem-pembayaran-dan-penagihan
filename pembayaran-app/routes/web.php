<?php

use App\Exports\PembayaranExport;
use App\Http\Controllers\ProfileController;
use App\Models\Nasabah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo-flow', function () {
    return view('demo-flow');
})->name('demo.flow');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'kasir') {
        return redirect()->route('kasir.dashboard');
    }

    return redirect()->route('marketing.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return 'Admin Page';
    });

    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.dashboard', [
            'totalNasabah' => Nasabah::count(),
            'totalTagihan' => Tagihan::sum('jumlah_tagihan'),
            'totalPembayaran' => Pembayaran::sum('jumlah_bayar'),
            'belumLunas' => Tagihan::where('status', 'belum_lunas')->count(),
            'daftarNasabah' => Nasabah::latest('id')->take(10)->get(),
            'daftarTagihan' => Tagihan::with('nasabah')->latest('id')->take(10)->get(),
            'riwayatPembayaran' => Pembayaran::with('tagihan.nasabah')->latest('id')->take(10)->get(),
        ]);
    })->name('admin.dashboard');

    Route::post('/approve/{tagihan}', function (Tagihan $tagihan) {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tagihan->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back();
    })->name('tagihan.approve');

    Route::post('/reject/{tagihan}', function (Tagihan $tagihan) {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tagihan->update([
            'approval_status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back();
    })->name('tagihan.reject');

    Route::get('/kasir/dashboard', function () {
        if (auth()->user()->role !== 'kasir') {
            abort(403);
        }

        return view('kasir.dashboard', [
            'pembayaranHariIni' => Pembayaran::whereDate('tanggal_bayar', today())->sum('jumlah_bayar'),
            'riwayatPembayaran' => Pembayaran::with('tagihan.nasabah')->latest('id')->take(15)->get(),
        ]);
    })->name('kasir.dashboard');

    Route::get('/marketing/dashboard', function () {
        if (auth()->user()->role !== 'marketing') {
            abort(403);
        }

        $tunggakanQuery = Tagihan::with('nasabah')
            ->where('status', 'belum_lunas')
            ->whereDate('jatuh_tempo', '<', now());

        return view('marketing.dashboard', [
            'daftarNasabah' => Nasabah::latest('id')->take(15)->get(),
            'daftarTagihan' => Tagihan::with('nasabah')->latest('id')->take(15)->get(),
            'tagihanBelumLunas' => Tagihan::with('nasabah')
                ->where('status', 'belum_lunas')
                ->latest('id')
                ->take(15)
                ->get(),
            'tunggakan' => $tunggakanQuery->latest('jatuh_tempo')->get(),
            'totalTunggakan' => (clone $tunggakanQuery)->sum('jumlah_tagihan'),
        ]);
    })->name('marketing.dashboard');

    // Bonus akses fitur berbasis role.
    Route::get('/tagihan/{tagihan}/edit', function (Tagihan $tagihan) {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return "Edit tagihan #{$tagihan->id}";
    })->name('tagihan.edit');

    Route::get('/pembayaran/create', function () {
        if (auth()->user()->role !== 'kasir' && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return 'Form input pembayaran';
    })->name('pembayaran.create');

    Route::get('/export/pembayaran', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return Excel::download(new PembayaranExport, 'pembayaran.xlsx');
    })->name('export.pembayaran');
});

require __DIR__.'/auth.php';
