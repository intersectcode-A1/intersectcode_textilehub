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
use App\Http\Controllers\Admin\TrackingController;
use App\Http\Controllers\SalesAnalysisController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route resource produk tanpa prefix admin dihapus, karena sudah ada di admin prefix.
// Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Route::prefix('shop')->group(function () {
//     Route::get('/katalog', [ShopController::class, 'index'])->name('katalog');
//     Route::post('/keranjang/tambah', [ShopController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
//     Route::get('/keranjang', [ShopController::class, 'lihatKeranjang'])->name('keranjang');
//     Route::post('/checkout', [ShopController::class, 'prosesCheckout'])->name('checkout.proses');
// });

Route::middleware('auth')->group(function () {
    // Dashboard User/Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout POST method
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});

Route::get('/admin/analisis-penjualan', [SalesAnalysisController::class, 'index'])->name('admin.sales.analysis');

// =============================
// 🛠️ Admin Panel (Protected by auth middleware)
// =============================
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Produk dan Kategori
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});



    // Manajemen Pesanan
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

     //tracking
    Route::get('/pelacakan', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/pelacakan', [TrackingController::class, 'search'])->name('tracking.search');
;
