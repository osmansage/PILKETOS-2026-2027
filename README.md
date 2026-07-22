# E-Voting Ketua OSIS SMAN 1 Gedeg

Project website e-voting berbasis PHP Native, MySQL, Tailwind CSS, JavaScript Vanilla, Font Awesome, dan AOS Animation.

## Fitur

- Login siswa menggunakan nama dan password dari database.
- Satu akun hanya dapat memilih satu kali.
- Voting 3 calon ketua dengan modal konfirmasi.
- Penyimpanan suara menggunakan PDO, prepared statement, transaksi, session, CSRF protection, dan output escaping.
- Halaman terima kasih setelah voting.
- Dashboard admin real-time dengan Fetch API, grafik voting, statistik peserta, dan progress bar kandidat.

## Instalasi

1. Salin folder project ke direktori web server, misalnya `htdocs/PILKETOS-026-2027` jika memakai XAMPP.
2. Jalankan Apache dan MySQL.
3. Import file `database.sql` ke MySQL melalui phpMyAdmin atau terminal.
4. Sesuaikan konfigurasi database di `config/database.php`.
5. Buka project dari browser:

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

File SQL membuat 1360 akun siswa otomatis.

```text
Nama: Siswa 0001
Password: password
```

Contoh lain:

```text
Siswa 0002
Siswa 0120
Siswa 1360
```

Semua akun siswa contoh memakai password `password`.

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

- Password disimpan dengan hash BCrypt dan diverifikasi dengan `password_verify`.
- Semua query memakai PDO prepared statement.
- Proses voting memakai database transaction dan `SELECT ... FOR UPDATE`.
- Tabel `votes` memakai unique key pada `user_id` agar satu user hanya bisa memiliki satu suara.
- Form login dan voting memakai CSRF token.
- Output HTML memakai `htmlspecialchars`.
