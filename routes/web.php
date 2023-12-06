<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('masuk');
});

Route::get('masuk', [AuthController::class, 'masuk'])->name('login');
Route::post('masuk', [AuthController::class, 'postMasuk'])->name('post.masuk');
Route::get('keluar', [AuthController::class, 'keluar'])->name('keluar');

Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    // Dashboard Admin
    Route::get('admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Outlet
    Route::get('json/outlet', [OutletController::class, 'json'])->name('json.outlet');
    Route::resource('outlet', OutletController::class);
    Route::patch('outlet/outlet/{id}/update', [OutletController::class, 'update']);

    // Paket/Cucian
    Route::get('json/paket/outlet', [PaketController::class, 'json'])->name('json.paket.outlet');
    Route::get('json/paket/{idOutlet}', [PaketController::class, 'jsonFilter'])->name('json.paket');
    Route::resource('paket', PaketController::class);

    // Pengguna
    Route::get('json/pengguna', [PenggunaController::class, 'json'])->name('json.pengguna');
    Route::resource('pengguna', PenggunaController::class);
    Route::get('pengguna/{id}/profile', [PenggunaController::class, 'profile']);

    // Update Password Pengguna
    Route::post('/ganti/kata-sandi/{id}/pengguna', [PenggunaController::class, 'updatePw'])->name('updatePw.pengguna');

    // Coba Dynamic
    Route::get('/coba/dynamic', [TransaksiController::class, 'coba'])->name('coba');
});

Route::middleware(['auth', 'checkRole:admin,kasir'])->group(function () {
    // Dashboard Kasir
    Route::get('kasir/dashboard', [DashboardController::class, 'kasir'])->name('kasir.dashboard');

    // Pelanggan
    Route::get('json/pelanggan', [PelangganController::class, 'json'])->name('json.pelanggan');
    Route::resource('pelanggan', PelangganController::class);

    // Transaksi
    Route::get('json/transaksi', [TransaksiController::class, 'json'])->name('json.transaksi');
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/json/{id}/cari-pelanggan', [TransaksiController::class, 'cariMember']);
    Route::get('tambah-paket/{idTransaksi}/transaksi/{idOutlet}', [TransaksiController::class, 'tPaket'])->name('tPaket');
    Route::get('/json/cari-paket/{id}/detail-transaksi', [TransaksiController::class, 'detailTransaksi'])->name('json.dTransaksi');
    Route::get('/json/{id}/status', [TransaksiController::class, 'jsonStatus']);
    Route::patch('/status/{id}/update', [TransaksiController::class, 'statusUpdate']);
    Route::post('tambah-paket/{id}/detail-transaksi', [TransaksiController::class, 'tPaketStore'])->name('tPaketStore');
    Route::delete('dPaket/{id}', [TransaksiController::class, 'destroyPaket'])->name('dPaket');
    Route::post('update/transaksi/{id}/detail-transaksi', [TransaksiController::class, 'updateTransaksi'])->name('uTransaksi');
    Route::get('/detail-transaksi/{kodeinvoice}/cucian', [TransaksiController::class, 'detailView']);

    // Json Dynamic Dropdown
    Route::get('json/cari-paket/{id}', [TransaksiController::class, 'paket']);
    Route::get('json/cari-jenis/{id}/{namaPaket}', [TransaksiController::class, 'jenis']);
    Route::get('json/cari-harga/{id}', [TransaksiController::class, 'harga']);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::middleware(['auth', 'checkRole:admin,kasir,owner'])->group(function () {
    // Dashboard Owner
    Route::get('owner/dashboard', [DashboardController::class, 'owner'])->name('owner.dashboard');

    // Outlet
    Route::get('owner/outlet', [OutletController::class, 'owner'])->name('owner.outlet');

    Route::get('json/outlet/owner', [OutletController::class, 'jsonOwner'])->name('json.outlet.owner');

    // Laporan
    Route::get('owner/laporan', [LaporanController::class, 'laporanOwner'])->name('laporan.owner');
    Route::post('laporan/cari', [LaporanController::class, 'cari'])->name('laporan.cari');

    // Export
    Route::get('laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    Route::get('laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');

    // Ganti Password
    Route::get('/ganti/{user}/kata-sandi', [AuthController::class, 'gantiKs'])->name('ganti.ks');
    Route::post('/ganti/{user}/kata-sandi', [AuthController::class, 'updatePw'])->name('pengguna.gantiPw');


});

