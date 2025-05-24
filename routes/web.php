<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Livewire Auth Components
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;

// Controllers
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\SalesAnalysisController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Admin\TrackingController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\KatalogController;

// Middleware
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================
// 🔓 Public Routes
// ======================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ======================
// 🧑‍💻 Guest Auth Routes
// ======================

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// ======================
// 🔐 Authenticated Routes
// ======================

Route::middleware('auth')->group(function () {
    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // E-Catalog harus login
    Route::get('/ecatalog', [PublicProductController::class, 'index'])->name('ecatalog.index');
    Route::get('/ecatalog/{id}', [PublicProductController::class, 'show'])->name('ecatalog.detail');

    // laporan
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');
    Route::post('/laporan-keuangan/filter', [LaporanKeuanganController::class, 'filter'])->name('laporan.filter');

    // Checkout dan Submit Order
    Route::post('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/order/submit', [CheckoutController::class, 'submit'])->name('order.submit');

    // ✅ Tambahan: Lihat status pesanan
    Route::get('/order/status', [CheckoutController::class, 'status'])->name('order.status');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});

// ======================
// 🛠️ Admin Panel Routes
// ======================

Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD Produk & Kategori
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Pelacakan
    Route::get('/pelacakan', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/pelacakan', [TrackingController::class, 'search'])->name('tracking.search');

    // Analisis Penjualan
    Route::get('/analisis-penjualan', [SalesAnalysisController::class, 'index'])->name('admin.sales.analysis');

    // Kelola Data Supplier
    Route::resource('supplier', SupplierController::class);
});
