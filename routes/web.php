<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;

// =============================
// 🏠 Halaman Utama
// =============================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =============================
// 👤 Auth (Login, Register, Reset Password)
// =============================
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// =============================
// 🛒 Fitur Belanja (Shop)
// =============================
Route::prefix('shop')->group(function () {
    Route::get('/katalog', [ShopController::class, 'index'])->name('katalog');
    Route::post('/keranjang/tambah', [ShopController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
    Route::get('/keranjang', [ShopController::class, 'lihatKeranjang'])->name('keranjang');
    Route::post('/checkout', [ShopController::class, 'prosesCheckout'])->name('checkout.proses');
});

<<<<<<< Updated upstream
// =============================
// 🔒 Setelah Login (User/Admin)
// =============================
Route::middleware('auth')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout menggunakan POST method
=======
// ======================
// 🔐 Authenticated Routes (User Biasa)
// ======================

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // E-Catalog
    Route::get('/ecatalog', [PublicProductController::class, 'index'])->name('ecatalog.index');
    Route::get('/ecatalog/{id}', [PublicProductController::class, 'show'])->name('ecatalog.detail');

    // Laporan Keuangan
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');
    Route::post('/laporan-keuangan/filter', [LaporanKeuanganController::class, 'filter'])->name('laporan.filter');

    // Checkout dan Submit Order
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/order/submit', [CheckoutController::class, 'submit'])->name('order.submit');

    // Status Pesanan
    Route::get('/order/status', [CheckoutController::class, 'status'])->name('order.status');
    Route::get('/order/status/{id}', [CheckoutController::class, 'statusDetail'])->name('order.status.detail');

    // Logout
>>>>>>> Stashed changes
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home'); // kembali ke halaman utama (welcome)
    })->name('logout');
});

// =============================
// 🛠️ Admin Panel (Proteksi Login)
// =============================
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

<<<<<<< Updated upstream
    // Manajemen Produk & Kategori
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Manajemen Pesanan
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
=======
// ======================
// 🛠️ Admin Panel Routes
// ======================

Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    // Produk & Kategori
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Pesanan dari user
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Status pesanan admin
    Route::get('/orders/{id}/status', [OrderController::class, 'statusDetail'])->name('orders.status.detail');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Pelacakan
    Route::get('/pelacakan', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/pelacakan', [TrackingController::class, 'search'])->name('tracking.search');

    // Analisis Penjualan
    Route::get('/analisis-penjualan', [SalesAnalysisController::class, 'index'])->name('admin.sales.analysis');

    // Supplier
    Route::resource('supplier', SupplierController::class);
>>>>>>> Stashed changes
});
