# TextileHub - E-Commerce Platform

Platform e-commerce untuk toko tekstil dengan fitur manajemen produk, pesanan, dan laporan keuangan yang komprehensif.

## Fitur Utama

### 🛍️ E-Catalog
- Katalog produk dengan kategori
- Detail produk dengan varian
- Keranjang belanja
- Checkout dan pembayaran
- Riwayat pesanan

### 📊 Dashboard Admin
- Dashboard dengan metrik penjualan
- Manajemen produk dan kategori
- Manajemen pesanan
- Analisis penjualan
- **Laporan Keuangan Terintegrasi** ✨

### 💰 Laporan Keuangan (Fitur Baru)

Fitur laporan keuangan yang sudah diperbaiki dan lebih berguna:

#### 📈 Analisis Komprehensif
- **Pendapatan**: Data penjualan dari orders yang completed
- **Pengeluaran**: Estimasi berdasarkan kategori (pembelian stok, operasional, gaji, marketing)
- **Profitabilitas**: Perhitungan profit berdasarkan harga modal supplier
- **Cash Flow**: Laporan arus kas operasional, investasi, dan pendanaan

#### 📊 Metrik Utama
- Total Pendapatan dengan perbandingan periode
- Total Pengeluaran dengan kategorisasi
- Total Profit dan Margin Profit
- Jumlah Transaksi dan Rata-rata Transaksi

#### 🏆 Analisis Performa
- **Produk Terlaris**: Ranking produk berdasarkan pendapatan
- **Kategori Terlaris**: Analisis kategori yang paling menguntungkan
- **Grafik Keuangan**: Visualisasi pendapatan, pengeluaran, dan profit

#### 📋 Cash Flow Statement
- **Operating Activities**: Pendapatan penjualan dan pengeluaran operasional
- **Investing Activities**: Pembelian aset
- **Financing Activities**: Pinjaman dan pembayaran pinjaman
- **Net Change in Cash**: Perubahan kas bersih

#### 📤 Export Excel
- Export laporan ke Excel dengan multiple sheets:
  - Ringkasan keuangan
  - Penjualan harian
  - Produk terlaris
  - Kategori terlaris
  - Cash flow statement

#### 🔗 Integrasi Data
- Terintegrasi dengan sistem order yang ada
- Menggunakan data penjualan real dari orders
- Estimasi pengeluaran yang realistis
- Perbandingan dengan periode sebelumnya

## Teknologi

- **Backend**: Laravel 10
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL
- **Export**: Laravel Excel
- **Charts**: Chart.js

## Instalasi

1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Setup database
5. Run migrations: `php artisan migrate`
6. Seed data: `php artisan db:seed`
7. Start server: `php artisan serve`

## Struktur Database

### Tabel Utama
- `users` - Pengguna sistem
- `products` - Produk dengan relasi ke supplier
- `categories` - Kategori produk
- `suppliers` - Supplier dengan harga modal
- `orders` - Pesanan customer
- `order_items` - Item dalam pesanan

### Relasi Penting
- Product ↔ Supplier (untuk analisis profitabilitas)
- Product ↔ Category (untuk analisis kategori)
- Order ↔ OrderItem (untuk analisis penjualan)

## Penggunaan Laporan Keuangan

1. **Akses**: Login sebagai admin → Laporan Keuangan
2. **Filter Periode**: Pilih tanggal mulai dan akhir
3. **Analisis**: Lihat metrik dan grafik
4. **Export**: Klik tombol "Export Excel" untuk download laporan lengkap

## Keunggulan Fitur Laporan Keuangan

✅ **Terintegrasi**: Menggunakan data penjualan real  
✅ **Komprehensif**: Analisis pendapatan, pengeluaran, dan profit  
✅ **Visual**: Grafik dan dashboard yang informatif  
✅ **Exportable**: Laporan Excel dengan multiple sheets  
✅ **Perbandingan**: Analisis tren periode sebelumnya  
✅ **Kategorisasi**: Pengeluaran dan produk terlaris  
✅ **Cash Flow**: Laporan arus kas yang detail  

---

Dikembangkan dengan ❤️ untuk Toko Usaha Muda