<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= page_title('Ubah Akun Admin'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="flex min-h-screen items-center justify-center px-4 py-10">
    <main class="glass w-full max-w-md rounded-[2rem] p-8">
        <a href="/admin" class="mb-6 inline-flex items-center gap-2 text-sm font-bold text-white underline decoration-white/30 underline-offset-4">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>
        <div class="mb-7 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-3xl text-[#07172f] shadow-xl"><i class="fa-solid fa-user-gear"></i></div>
            <h1 class="text-2xl font-black text-white">Ubah Akun Admin</h1>
            <p class="mt-2 text-sm text-slate-300">Masukkan password saat ini untuk menyimpan perubahan.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700"><?= e($error); ?></div>
        <?php endif; ?>
        <?php if ($flash): ?>
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700"><?= e($flash['message']); ?></div>
        <?php endif; ?>

        <form method="post" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
            <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-200">Username baru</span><input class="focus-ring w-full rounded-2xl border border-white/20 bg-white/90 px-4 py-3 font-semibold text-slate-900" type="text" name="username" value="<?= e($_SESSION['admin_username']); ?>" minlength="3" maxlength="60" required></label>
            <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-200">Password saat ini</span><input class="focus-ring w-full rounded-2xl border border-white/20 bg-white/90 px-4 py-3 font-semibold text-slate-900" type="password" name="current_password" required></label>
            <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-200">Password baru</span><input class="focus-ring w-full rounded-2xl border border-white/20 bg-white/90 px-4 py-3 font-semibold text-slate-900" type="password" name="new_password" minlength="8" required></label>
            <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-200">Konfirmasi password baru</span><input class="focus-ring w-full rounded-2xl border border-white/20 bg-white/90 px-4 py-3 font-semibold text-slate-900" type="password" name="confirm_password" minlength="8" required></label>
            <button class="btn-ripple flex w-full items-center justify-center gap-3 rounded-2xl bg-[#f6c85f] px-5 py-3 font-black text-[#07172f] shadow-xl transition hover:bg-white" type="submit"><i class="fa-solid fa-floppy-disk"></i>Simpan Perubahan</button>
        </form>
    </main>
    <script src="../assets/js/main.js"></script>
</body>
</html>
