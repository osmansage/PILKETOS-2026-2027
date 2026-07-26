<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= page_title('Dashboard Admin'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="min-h-screen px-4 py-8">
    <main class="mx-auto max-w-7xl" data-admin-dashboard>
        <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" data-aos="fade-down">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#f6c85f]">Dashboard Real-Time</p>
                <h1 class="text-3xl font-black text-white sm:text-4xl">Hasil E-Voting OSIS</h1>
                <p class="mt-2 text-slate-300">Login sebagai <?= e($_SESSION['admin_username']); ?>. <span data-refresh-status>Memuat data...</span></p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a class="btn-ripple inline-flex items-center justify-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-5 py-3 font-bold text-white shadow-xl transition hover:bg-white hover:text-[#07172f]" href="account.php">
                    <i class="fa-solid fa-user-gear"></i>
                    Ubah Akun
                </a>
                <a class="btn-ripple inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 font-black text-[#07172f] shadow-xl transition hover:-translate-y-0.5" href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Keluar
                </a>
            </div>
        </header>

        <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="glass rounded-[1.5rem] p-6" data-aos="fade-up">
                <i class="fa-solid fa-users mb-5 text-3xl text-[#54d6ff]"></i>
                <p class="text-sm font-semibold text-slate-300">Total Peserta</p>
                <p class="mt-2 text-4xl font-black text-white" data-total-voters>0</p>
            </div>
            <div class="glass rounded-[1.5rem] p-6" data-aos="fade-up" data-aos-delay="80">
                <i class="fa-solid fa-check-to-slot mb-5 text-3xl text-emerald-300"></i>
                <p class="text-sm font-semibold text-slate-300">Sudah Memilih</p>
                <p class="mt-2 text-4xl font-black text-white" data-voted>0</p>
            </div>
            <div class="glass rounded-[1.5rem] p-6" data-aos="fade-up" data-aos-delay="160">
                <i class="fa-solid fa-user-clock mb-5 text-3xl text-[#f6c85f]"></i>
                <p class="text-sm font-semibold text-slate-300">Belum Memilih</p>
                <p class="mt-2 text-4xl font-black text-white" data-not-voted>0</p>
            </div>
            <div class="glass rounded-[1.5rem] p-6" data-aos="fade-up" data-aos-delay="240">
                <i class="fa-solid fa-percent mb-5 text-3xl text-white"></i>
                <p class="text-sm font-semibold text-slate-300">Partisipasi</p>
                <p class="mt-2 text-4xl font-black text-white" data-participation>0%</p>
            </div>
        </section>

        <section class="mt-8 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="glass-light rounded-[2rem] p-6" data-aos="fade-right">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-slate-500">Grafik Voting</p>
                        <h2 class="text-2xl font-black text-[#07172f]">Distribusi Suara</h2>
                    </div>
                    <i class="fa-solid fa-chart-pie text-3xl text-[#07172f]"></i>
                </div>
                <canvas id="voteChart" class="h-80 w-full"></canvas>
            </div>

            <div class="space-y-5" data-aos="fade-left">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-[#f6c85f]">Hasil Real-Time</p>
                        <h2 class="text-2xl font-black text-white">Progress Kandidat</h2>
                    </div>
                    <i class="fa-solid fa-signal text-2xl text-white"></i>
                </div>
                <div class="grid gap-4" data-candidate-results></div>
            </div>
        </section>
    </main>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
