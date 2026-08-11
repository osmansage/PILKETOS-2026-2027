# E-Voting Ketua OSIS SMAN 1 Gedeg

Project website e-voting berbasis PHP Native, MySQL, Tailwind CSS, JavaScript Vanilla, Font Awesome, dan AOS Animation.

## Fitur

- Login siswa menggunakan kode peserta acak 20 karakter dari database.
- Satu akun hanya dapat memilih satu kali.
- Voting 3 calon ketua dengan modal konfirmasi.
- Penyimpanan suara menggunakan PDO, prepared statement, transaksi, session, CSRF protection, dan output escaping.
- Halaman terima kasih setelah voting.
- Dashboard admin real-time dengan Fetch API, grafik voting, statistik peserta, dan progress bar kandidat.

## Instalasi

1. Salin folder project ke direktori web server, misalnya `htdocs/PILKETOS-026-2027` jika memakai XAMPP.
2. Jalankan Apache dan MySQL.
3. Import file `database.sql` ke MySQL melalui phpMyAdmin atau terminal.
4. Jalankan importer kode peserta setelah file SQL selesai diimpor:

```powershell
C:\laragon\bin\php\php-8.1.32-nts-Win32-vs16-x64\php.exe database\import_codes.php "C:\Users\ACER\Downloads\1360_kode_acak_20_digit.xlsx"
```

5. Sesuaikan konfigurasi database di `config/database.php`.
6. Buka project dari browser:

```text
http://localhost/PILKETOS-026-2027/
```

## Import Database

Melalui phpMyAdmin:

1. Buka `http://localhost/phpmyadmin`.
2. Pilih menu Import.
3. Pilih file `database.sql`.
4. Jalankan import.

Melalui terminal:

```bash
mysql -u root -p < database.sql
```

Database default:

```text
Nama database: evoting_osis_gedeg
Host: localhost
User: root
Password: kosong
```

## Konfigurasi Database

Edit file `config/database.php` jika kredensial MySQL berbeda:

```php
$dbHost = 'localhost';
$dbName = 'evoting_osis_gedeg';
$dbUser = 'root';
$dbPass = '';
```

## Login Admin

```text
URL: /admin/login.php
Username: admin
Password: password
```

## Login Siswa

Impor workbook `1360_kode_acak_20_digit.xlsx` memakai `database/import_codes.php`. Script memvalidasi bahwa ada tepat 1.360 kode unik, lalu menyimpannya pada tabel `users`.

```text
Contoh kode: FZ9BRSTCWXD69V6SQ2AT
```

Kode tidak membedakan huruf besar atau kecil saat login, tetapi hanya menerima 20 karakter huruf dan angka.


## Struktur Folder

```text
/
├── admin/
├── api/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
├── config/
├── database/
├── includes/
├── login.php
├── vote.php
├── thanks.php
├── logout.php
├── index.php
├── README.md
└── database.sql
```

## Catatan Keamanan

- Password administrator disimpan dengan hash BCrypt dan diverifikasi dengan `password_verify`.
- Semua query memakai PDO prepared statement.
- Proses voting memakai database transaction dan `SELECT ... FOR UPDATE`.
- Tabel `votes` memakai unique key pada `user_id` agar satu user hanya bisa memiliki satu suara.
- Form login dan voting memakai CSRF token.
- Output HTML memakai `htmlspecialchars`.
