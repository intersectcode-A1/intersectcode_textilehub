# Textile Hub

Sistem manajemen dan e-katalog untuk industri tekstil.

## Fitur Utama

- Manajemen produk tekstil
- E-katalog dengan fitur pencarian
- Sistem pemesanan dan checkout
- Dashboard admin
- Manajemen pengguna dan hak akses
- Sistem notifikasi

## Persyaratan Sistem

- PHP >= 8.1
- Node.js >= 16
- MySQL >= 8.0
- Composer
- NPM

## Instalasi

1. Clone repository:
```bash
git clone https://github.com/yourusername/textile-hub.git
cd textile-hub
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di file `.env`

5. Jalankan migrasi:
```bash
php artisan migrate --seed
```

6. Link storage:
```bash
php artisan storage:link
```

7. Compile assets:
```bash
npm run dev
```

## Development

- `npm run dev` - Start Vite development server
- `php artisan serve` - Start Laravel development server
- `php artisan test` - Run tests
- `php artisan migrate:fresh --seed` - Reset database dengan data dummy

## Deployment

1. Set environment ke production di `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Build assets:
```bash
npm run build
```

## Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Security

Jika Anda menemukan masalah keamanan, silakan kirim email ke security@textilehub.com

## License

[MIT License](LICENSE)
