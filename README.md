# Game Store

## Setup setelah clone repo

1. Jalankan ini jika baru saja clone repo

```bash
composer install
npm install
```

2. Salin file `.env.example` menjadi `.env`.
   Untuk sementara gunakan sqlite, soalnya databasenya belum jadi (yang dikomen biarin aja)

```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

Lalu jalankan

```bash
php artisan key:generate`
php artisan migrate
```

## Cara menjalankan projek

1. Jalankan Tailwind (jika menggunakan tailwind)

```bash
npm run dev
```

2. Jalankan Laravel

```bash
php artisan serve
```
