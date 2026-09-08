<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rute Latihan / Practice (Bisa diakses bebas) ---
Route::name('index-practice')->get('/practice', function () {
    return view('pages.practice.index');
});

Route::name('practice.')->group(function () {
    Route::name('first')->get('practice/1', function () {
        return view('pages.practice.1');
    });
    Route::name('second')->get('practice/2', function () {
        return view('pages.practice.2');
    });
});


// --- Rute Tamu (Hanya bisa diakses jika BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});


// --- Rute Terproteksi (WAJIB login untuk mengakses sistem gudang) ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Utama otomatis mengarah ke Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Kategori (Tetap menggunakan format {id} milikmu)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Master Supplier & Produk
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);

    // Mutasi Persediaan
    Route::resource('stock-in', StockInController::class)->only(['index', 'store', 'destroy']);
    Route::resource('stock-out', StockOutController::class)->only(['index', 'store', 'destroy']);

    // Laporan Mutasi
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});