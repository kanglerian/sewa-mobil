
# Aplikasi Sewa Mobil - Tes Kerja PT. Jasamedika Saranatama

Ini adalah aplikasi sewa mobil yang dibuat untuk menjawab soal tes kerja PT. Jasamedika Saranatama.

## Cara Penggunaan

Untuk menjalankan aplikasi ini secara lokal, ikuti langkah-langkah berikut:

1. Clone repository ini ke dalam komputer Anda.
2. Install semua dependensi PHP dan Node.js dengan perintah:
    ```bash
    composer install
    npm install
    ```
3. Buat file `.env` dengan menyalin dari file `.env-example` yang ada, kemudian sesuaikan nama database dan konfigurasi lainnya sesuai kebutuhan Anda.
4. Lakukan migrasi database dengan perintah:
    ```bash
    php artisan migrate
    ```
5. Isi data awal ke dalam database dengan perintah:
    ```bash
    php artisan db:seed
    ```

Aplikasi siap digunakan dan dapat diakses melalui URL yang sesuai dengan konfigurasi server lokal Anda.

## Akun Default

- **Admin**:  
  Email: `admin@gmail.com`  
  Password: `admin123`

- **Client**:  
  - Email: `clientone@gmail.com`  
    Password: `client123`  
  - Email: `clienttwo@gmail.com`  
    Password: `client123`

## Teknologi

Aplikasi ini dibangun menggunakan Laravel 11.

## Author

Lerian Febriana
