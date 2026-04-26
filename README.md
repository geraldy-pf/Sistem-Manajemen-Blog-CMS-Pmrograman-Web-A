# Sistem Manajemen Blog (CMS) - No-Reload Interface

Proyek ini adalah sistem manajemen konten (CMS) sederhana yang memungkinkan pengelolaan data penulis, artikel, dan kategori secara dinamis. Fokus utama aplikasi ini adalah penggunaan **Fetch API (Asynchronous JavaScript)**, sehingga seluruh proses CRUD (Create, Read, Update, Delete) berjalan di latar belakang tanpa mengganggu kenyamanan pengguna dengan *page refresh*.

## 🛠️ Fitur Utama
- **Modern CRUD:** Pengelolaan data Penulis, Artikel, dan Kategori dilakukan secara *real-time* menggunakan Fetch API.
- **Asynchronous File Upload:** Unggah foto profil penulis dan gambar artikel tanpa reload halaman.
- **Auto-Formatting Date:** Penulisan tanggal artikel otomatis menggunakan format Indonesia (Asia/Jakarta).
- **Security First:** - Enkripsi password menggunakan `BCRYPT`.
    - Validasi file upload berbasis `finfo` (MIME type check) untuk mencegah manipulasi ekstensi file.
    - Penggunaan *Prepared Statements* (mysqli) untuk mencegah serangan SQL Injection.
    - Proteksi folder upload menggunakan file `.htaccess` agar file PHP tidak bisa dieksekusi dari direktori gambar.

## 🗄️ Struktur Database (`db_blog`)
Aplikasi ini berjalan di atas tiga tabel utama dengan relasi *Constraint*:
1. **`penulis`**: Menyimpan identitas, username, dan foto profil.
2. **`kategori_artikel`**: Pengelompokan jenis konten.
3. **`artikel`**: Berisi konten blog yang terhubung dengan penulis dan kategori melalui *Foreign Key*.

## 📂 Panduan Instalasi Lokal

1. **Persiapan Folder:**
   Pastikan folder proyek diletakkan di `htdocs` (XAMPP) atau direktori server lokal Anda lainnya.
   
2. **Setup Database:**
   - Masuk ke `phpMyAdmin`.
   - Buat database baru bernama `db_blog`.
   - Salin dan jalankan (import) seluruh perintah SQL yang ada di modul proyek untuk membuat tabel dan relasi.

3. **Struktur Folder Penting:**
   Pastikan folder berikut ada dan memiliki izin tulis (*write access*):
   - `uploads_penulis/` (Siapkan file `default.png` di dalamnya untuk siluet awal).
   - `uploads_artikel/`.

4. **Konfigurasi:**
   Buka file koneksi database (misal: `config.php`) dan sesuaikan *credentials* MySQL (host, user, pass) Anda.

## 🚀 Cara Penggunaan
- **Menu Penulis:** Kelola akun pengelola konten. Data tidak bisa dihapus jika penulis tersebut masih memiliki artikel aktif (**Restricted Delete**).
- **Menu Artikel:** Tulis konten dengan memilih penulis dan kategori yang tersedia. Gambar wajib diunggah (maksimal 2MB).
- **Menu Kategori:** Kelola kategori artikel. Kategori yang sedang digunakan oleh artikel tidak dapat dihapus demi integritas data.

## 💡 Spesifikasi Teknis
- **Language:** PHP 8.x
- **Database:** MariaDB/MySQL (InnoDB Engine)
- **Frontend:** Vanilla JavaScript (Fetch API) & CSS Layouting.
- **Backend Protection:** `password_hash`, `htmlspecialchars`, dan validasi ukuran file.

---
**Catatan:** Proyek ini dikembangkan untuk memenuhi standar tugas Pemrograman Web dengan penekanan pada integrasi PHP-MySQL dan interaksi sisi klien yang responsif.
