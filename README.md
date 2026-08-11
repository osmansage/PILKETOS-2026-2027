# E-Voting Ketua OSIS SMAN 1 Gedeg

Project website e-voting berbasis arsitektur Clean MVC modern menggunakan PHP Native, MariaDB/MySQL, Tailwind CSS, JavaScript Vanilla, Font Awesome, dan AOS Animation.

---

## Fitur Unggulan

- **Centralized Router & Clean URLs**: URL rapi tanpa ekstensi `.php` (misal `/login`, `/vote`, `/thanks`, `/admin`). Ekstensi lama secara otomatis dialihkan (301 Redirect).
- **Web Installer Wizard (`/install`)**: Memudahkan proses pemasangan pertama kali. Membuat basis data otomatis, mengimpor skema kueri dari `database.sql`, dan mengatur akun admin utama lewat browser.
- **Dashboard Admin Dinamis**:
  - **Hasil Real-Time**: Distribusi suara dengan grafik diagram lingkaran dinamis dan progress bar perolehan suara yang diperbarui otomatis setiap 5 detik.
  - **Kelola Kandidat**: Edit nama, visi, misi, dan perbarui foto calon ketua OSIS secara aman dari dashboard admin.
  - **Manajemen Kode**: Pencarian kode secara langsung (*live search*), filter status (*Semua, Belum Memilih, Sudah Memilih*), paginasi AJAX super cepat, generate ulang kode baru, serta impor kode dari berkas Excel (`.xlsx`) dan ekspor daftar kode ke CSV.
- **Sistem Voting Kokoh**: Transaksi row-locking (`SELECT ... FOR UPDATE`) untuk menjamin satu kode pemilih hanya dapat mengirim satu suara meskipun diakses bersamaan.

---

## Instalasi Cepat

1. Salin seluruh berkas proyek ke direktori web server (misalnya `htdocs/PILKETOS-2026-2027` jika menggunakan XAMPP, atau buat virtual host di Apache).
2. Jalankan Apache dan MySQL/MariaDB server Anda.
3. Buka browser dan akses halaman installer otomatis di:
   ```text
   http://localhost/PILKETOS-2026-2027/install
   ```
4. Masukkan kredensial database Anda (host, username, password, dan nama database) serta username & password admin baru yang diinginkan.
5. Tekan tombol **Simpan & Pasang Sekarang**. Sistem akan membuat database secara otomatis, mengimpor tabel, dan mengarahkan Anda ke halaman login.

---

## Panduan Penggunaan URL

| Halaman | Rute Bersih |
| :--- | :--- |
| **Instalasi Awal** | `/install` |
| **Login Siswa** | `/login` |
| **Pilih Kandidat** | `/vote` |
| **Terima Kasih** | `/thanks` |
| **Dashboard Admin** | `/admin` |
| **Login Admin** | `/admin/login` |
| **Ubah Password Admin** | `/admin/account` |

---

## Struktur Folder Proyek

```text
/
├── app/
│   ├── Controllers/   # Controller MVC (Auth, Vote, Admin, Install)
│   ├── Core/          # Inti Framework (Database, Controller, Security, Session)
│   ├── Models/        # Model Interaksi Database (User, Candidate, Vote, Admin)
│   └── Views/         # File Layout & Template Tampilan
├── assets/
│   ├── css/           # File Style Custom
│   ├── js/            # Javascript Utama (AJAX & Dynamic Chart)
│   ├── images/        # Ilustrasi SVG & Gambar Sistem
│   └── uploads/       # Direktori Penyimpanan Foto Kandidat (Uploads)
├── config/            # Berkas Konfigurasi Database & Sesi
├── database/          # Generator Mock Data & Importer Excel CLI
├── bootstrap.php      # Bootstrap Loading Autoload PSR-4 & Helpers
├── index.php          # Front Controller Router Pusat
├── .htaccess          # URL Rewriting untuk Server Apache
├── database.sql       # Skema DDL Database
└── README.md          # Dokumentasi Proyek
```

---

## Catatan Keamanan & Hardening

- **Anti RCE (Remote Code Execution)**: Menggunakan pendeteksi biner bawan server (`finfo_file`) saat mengunggah foto kandidat untuk menangkal pemalsuan jenis berkas (MIME-spoofing).
- **Perlindungan Akses Direktori**: Akses publik langsung menuju direktori core (`app/`, `config/`, `database/`) ditolak secara ketat menggunakan berkas `.htaccess` di Apache dan filter regex di skrip router lokal.
- **SQL Injection Prevention**: Menggunakan PDO prepared statement dengan parameter binding murni untuk seluruh kueri SQL.
- **CSRF Mitigation**: Semua operasi pengiriman data (POST) dikunci dengan CSRF Token acak berbasis session.
- **XSS Prevention**: Melakukan escaping menggunakan `htmlspecialchars` bersandi `UTF-8` pada semua variabel yang ditampilkan ke browser.
