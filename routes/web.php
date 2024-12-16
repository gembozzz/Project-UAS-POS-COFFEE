<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('admin/index');
});
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('/admin')->middleware('auth', 'role:admin')->group(function (){
    Route::get('/dashboard', [HomeController::class, 'indexAdmin'])->name('admin.dashboard');
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/produk', ProdukController::class);
    Route::resource('/member', MemberController::class);

    
});

Route::prefix('/kasir')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'indexKasir'])->name('kasir.dashboard');
    
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::resource('penjualan', PenjualanController::class);
    // Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    // Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    // Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('transaksi', PenjualanDetailController::class)
        ->except('create', 'show', 'edit');
});
