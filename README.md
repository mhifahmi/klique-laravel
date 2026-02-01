# Klique - Sistem Antrian Klinik Berbasis Web

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-563D7C?style=for-the-badge&logo=bootstrap)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4e56a6?style=for-the-badge&logo=livewire)

**Klique** adalah aplikasi manajemen antrian klinik berbasis web yang dirancang modern, responsif, dan *real-time*. Dibangun menggunakan **Laravel 12**, aplikasi ini membantu staf klinik mengelola aliran pasien dan dokter, serta menyediakan tampilan monitor antrian untuk ruang tunggu.

---

## Studi Kasus

Banyak klinik kecil mengalami kesulitan dalam mengatur antrian pasien, terutama saat jumlah kunjungan tinggi. Ketidakjelasan urutan antrian dapat menimbulkan ketidakpuasan pasien dan menyulitkan administrasi staf.

**Solusi:**
Aplikasi Klique menawarkan solusi digital yang mencakup:
- Pendaftaran & Pencarian Pasien Cepat.
- Manajemen Antrian Interaktif (*Real-time* tanpa refresh halaman menggunakan Livewire).
- Monitor TV untuk Ruang Tunggu.
- Dashboard Statistik Harian.

---

## Fitur Utama

### 1. Halaman Publik (Pengunjung)
- **Landing Page:** Pilihan menu awal.
- **TV Monitor Antrian:** Menampilkan nomor antrian besar yang sedang dipanggil, antrian berikutnya, dan status ketersediaan dokter/ruangan secara *real-time*.

### 2. Area Staf (Dashboard)
#### Dashboard Statistik
- Ringkasan jumlah pasien hari ini.
- Sisa antrian menunggu.
- Pasien selesai dilayani.
- Kartu status dokter/ruangan aktif dengan indikator warna.

#### Operator Antrian (Livewire)
Fitur unggulan untuk memanggil pasien tanpa reload halaman:
- **Nomor Besar:** Menampilkan siapa yang sedang dipanggil.
- **Kontrol Panggilan:** Tombol *Panggil Selanjutnya*, *Panggil Terlewat*, dan *Skip*.
- **Quick Add:** Tambah antrian baru langsung dari halaman operator dengan fitur *autocomplete* pencarian pasien.

#### Manajemen Data (CRUD)
- **Data Pasien:** Tambah, Edit, Hapus, dan Lihat Detail Pasien (Modal Pop-up).
- **Data Dokter:** Manajemen profil dokter dan SIP.
- **Manajemen Ruangan:** Mengatur status ruangan (Tersedia / Penuh / Istirahat).

---

## Teknologi yang Digunakan

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templates, Bootstrap 5 (CDN)
- **Interaktivitas:** Laravel Livewire 3 (Untuk fitur Antrian & Search)
- **Database:** MySQL / MariaDB
- **Tools:** Composer, Git

---

## Cara Install & Jalankan

Ikuti langkah-langkah berikut untuk menjalankan project di komputer lokal:

### 1. Clone Repository
```bash
git clone [https://github.com/mhifahmi/klique-laravel.git](https://github.com/mhifahmi/klique-laravel.git)
cd klique-laravel
```

### 2. Install Dependencies
Pastikan Composer sudah terinstall.
```bash
composer install
```

### 3. Konfigurasi Environment
Duplikat file `.env.example` menjadi `.env`, lalu atur database.
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database (pastikan DB sudah dibuat di MySQL):
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=klique_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key & Migrasi Database
Jalankan perintah berikut untuk mengisi struktur tabel dan data dummy:
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```
Perintah `--seed` akan otomatis mengisi data dummy (50 Pasien, 10 Dokter, Akun Admin) agar aplikasi siap dites.

### 5. Jalankan Server
```bash
composer run dev
```
Buka browser dan akses: http://127.0.0.1:8000
