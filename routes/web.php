<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Livewire Auth Components
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;

// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\SalesAnalysisController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\HargaStrategiController;
use App\Http\Controllers\Admin\AnalisisPenjualanController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\NotificationController;

// Middleware
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔓 Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🧑‍💻 Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// 🔐 Authenticated Routes (User Biasa)
Route::middleware(['auth', 'web'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // E-Catalog
    Route::get('/ecatalog', [PublicProductController::class, 'index'])->name('ecatalog.index');
    Route::get('/ecatalog/{id}', [PublicProductController::class, 'show'])->name('ecatalog.show');
    
    // Riwayat & Status Pesanan
    Route::get('/purchase-history', [CatalogController::class, 'purchaseHistory'])->name('purchase.history');
    Route::get('/order-status', [CatalogController::class, 'orderStatus'])->name('order.status');
    Route::get('/order/{id}', [CatalogController::class, 'orderDetail'])->name('order.detail');
    Route::get('/order/{order}/invoice-pdf', [\App\Http\Controllers\User\OrderController::class, 'invoicePdf'])->name('order.invoice.pdf');
    Route::patch('/order/{id}/cancel', [CatalogController::class, 'cancel'])->name('order.cancel')->middleware('web');

    // Pembayaran
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{id}/process', [PaymentController::class, 'process'])->name('payment.process');



    // Checkout dan Submit Order
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::get('/checkout-direct/{id}', [CheckoutController::class, 'showDirect'])->name('checkout.direct');
    Route::post('/order/submit', [CheckoutController::class, 'submit'])->name('order.submit');
    Route::post('/order/submit-cart', [CheckoutController::class, 'submitFromCart'])->name('order.submit.cart');
    Route::get('/checkout-cart', [CartController::class, 'checkoutFromCart'])->name('checkout.cart');

    // 🛒 Keranjang (User)
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');

    Route::get('/bantuan-pengiriman', function() {
        return view('ecatalog.bantuan-pengiriman');
    })->name('bantuan.pengiriman');
});

// 🛠️ Admin Panel Routes
Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Produk & Kategori
    Route::resource('products', ProductController::class);
    Route::get('/products/export/stock', [ProductController::class, 'exportStock'])->name('products.export.stock');
    Route::resource('categories', CategoryController::class);
    Route::resource('product-variants', \App\Http\Controllers\Admin\ProductVariantController::class);

    // Pesanan dari user
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{id}/verify-payment', [OrderController::class, 'verifyPayment'])->name('orders.verifyPayment');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Analisis Penjualan
    Route::get('/analisis-penjualan', [AnalisisPenjualanController::class, 'index'])->name('admin.sales.analysis');
    Route::get('/analisis-penjualan/export', [AnalisisPenjualanController::class, 'export'])->name('admin.sales.analysis.export');

    // Inventory Logs
    Route::get('/inventory-logs', [\App\Http\Controllers\Admin\InventoryLogController::class, 'index'])->name('inventory-logs.index');
    Route::get('/inventory-logs/create', [\App\Http\Controllers\Admin\InventoryLogController::class, 'create'])->name('inventory-logs.create');
    Route::post('/inventory-logs', [\App\Http\Controllers\Admin\InventoryLogController::class, 'store'])->name('inventory-logs.store');
    Route::get('/inventory-logs/{id}', [\App\Http\Controllers\Admin\InventoryLogController::class, 'show'])->name('inventory-logs.show');
    Route::get('/inventory-logs/export', [\App\Http\Controllers\Admin\InventoryLogController::class, 'export'])->name('inventory-logs.export');
    Route::delete('/inventory-logs/{id}', [\App\Http\Controllers\Admin\InventoryLogController::class, 'destroy'])->name('inventory-logs.destroy');
    Route::get('/inventory-logs/{id}/edit', [\App\Http\Controllers\Admin\InventoryLogController::class, 'edit'])->name('inventory-logs.edit');
    Route::put('/inventory-logs/{id}', [\App\Http\Controllers\Admin\InventoryLogController::class, 'update'])->name('inventory-logs.update');

    // Supplier
    Route::resource('supplier', SupplierController::class);

    // Store Order
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Strategi Harga
    Route::get('/harga-strategi', [HargaStrategiController::class, 'index'])->name('admin.harga-strategi.index');
    Route::post('/harga-strategi/{product}/update', [HargaStrategiController::class, 'updateHarga'])->name('admin.harga-strategi.update');
    Route::get('/harga-strategi/{product}/history', [HargaStrategiController::class, 'getPriceHistory'])->name('admin.harga-strategi.history');
    Route::get('/harga-strategi/{product}/edit', [HargaStrategiController::class, 'edit'])->name('admin.harga-strategi.edit');
    Route::get('/harga-strategi/export', [HargaStrategiController::class, 'exportExcel'])->name('admin.harga-strategi.export');
    Route::post('/harga-strategi/bulk-update', [HargaStrategiController::class, 'bulkUpdate'])->name('admin.harga-strategi.bulkUpdate');

    // Notifications
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

    // Laporan Keuangan
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('admin.laporan.index');
    Route::post('/laporan-keuangan/filter', [LaporanKeuanganController::class, 'filter'])->name('laporan.filter');
    Route::post('/laporan-keuangan/export', [LaporanKeuanganController::class, 'export'])->name('admin.laporan.export');

    // Manual Invoice Creation
    Route::get('/manual-invoice', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'index'])->name('admin.manual-invoice.index');
    Route::get('/manual-invoice/create', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'create'])->name('admin.manual-invoice.create');
    Route::post('/manual-invoice', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'store'])->name('admin.manual-invoice.store');
    Route::get('/manual-invoice/{id}', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'show'])->name('admin.manual-invoice.show');
    Route::get('/manual-invoice/{id}/download', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'download'])->name('admin.manual-invoice.download');
    Route::delete('/manual-invoice/{id}', [\App\Http\Controllers\Admin\ManualInvoiceController::class, 'destroy'])->name('admin.manual-invoice.destroy');

    // Expense Management
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::resource('expenses', ExpenseController::class);
});