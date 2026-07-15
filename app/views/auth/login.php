<?php
$demoAccounts = [
    ['role' => 'Admin', 'team' => 'Kelola semua data', 'email' => 'admin@futsalkit.com', 'password' => 'admin123', 'badge' => 'ADMIN'],
    ['role' => 'Manager', 'team' => 'FC Barcelona Futsal', 'email' => 'manager@futsalkit.com', 'password' => 'manager123', 'badge' => 'APPROVED'],
    ['role' => 'Manager', 'team' => 'Real Madrid Futsal', 'email' => 'madrid@futsalkit.com', 'password' => 'manager123', 'badge' => 'PENDING'],
    ['role' => 'Manager', 'team' => 'Manchester City Futsal', 'email' => 'manchester@futsalkit.com', 'password' => 'manager123', 'badge' => 'APPROVED'],
    ['role' => 'Manager', 'team' => 'Garuda United Futsal', 'email' => 'garuda@futsalkit.com', 'password' => 'manager123', 'badge' => 'APPROVED'],
    ['role' => 'Manager', 'team' => 'Nusantara Warriors Futsal', 'email' => 'nusantara@futsalkit.com', 'password' => 'manager123', 'badge' => 'PENDING'],
];
?>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FutsalKit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { font-family: 'Outfit', ui-sans-serif, system-ui, sans-serif; letter-spacing: 0; }
        body {
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.94), rgba(3, 7, 18, 0.98)),
                repeating-linear-gradient(90deg, rgba(34, 197, 94, 0.04) 0 1px, transparent 1px 96px),
                #020617;
        }
        .pitch-lines {
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 48px 48px;
        }
    </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
    <main class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 pitch-lines opacity-70"></div>

        <div class="relative mx-auto flex min-h-screen w-full max-w-6xl items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <section class="grid w-full overflow-hidden rounded-[28px] border border-slate-700/70 bg-slate-950/80 shadow-2xl shadow-black/40 backdrop-blur lg:grid-cols-[420px_minmax(0,1fr)]">
                <div class="flex min-h-[640px] items-center border-slate-700/70 bg-slate-950 p-5 sm:p-8 lg:border-r">
                    <div class="mx-auto w-full max-w-sm">
                        <div class="mb-10">
                            <a href="<?php echo BASE_URL; ?>/login" class="inline-flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-slate-950 shadow-lg shadow-emerald-500/20">
                                    <i class="bi bi-dribbble text-xl"></i>
                                </span>
                                <span>
                                    <span class="block text-xl font-extrabold text-white">FutsalKit</span>
                                    <span class="block text-xs font-semibold uppercase text-emerald-300">Tournament Manager</span>
                                </span>
                            </a>
                        </div>

                        <div class="mb-7">
                            <p class="mb-2 text-sm font-semibold text-emerald-300">Selamat datang kembali</p>
                            <h2 class="text-3xl font-extrabold text-white">Login Akun</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-400">Gunakan akun admin atau manager yang sudah terdaftar.</p>
                        </div>

                        <?php foreach (['success','danger','warning','info'] as $t):
                            if (!Session::hasFlash($t)) continue;
                            $styles = [
                                'success' => ['border-emerald-400/30 bg-emerald-400/10 text-emerald-200', 'bi-check-circle-fill'],
                                'danger' => ['border-red-400/30 bg-red-400/10 text-red-200', 'bi-exclamation-triangle-fill'],
                                'warning' => ['border-amber-400/30 bg-amber-400/10 text-amber-200', 'bi-exclamation-circle-fill'],
                                'info' => ['border-cyan-400/30 bg-cyan-400/10 text-cyan-200', 'bi-info-circle-fill']
                            ];
                        ?>
                        <div class="mb-4 flex items-start gap-3 rounded-2xl border px-4 py-3 text-sm <?php echo $styles[$t][0]; ?>" role="alert">
                            <i class="bi <?php echo $styles[$t][1]; ?> mt-0.5 flex-shrink-0"></i>
                            <span><?php echo Session::getFlash($t); ?></span>
                        </div>
                        <?php endforeach; ?>

                        <form action="<?php echo BASE_URL; ?>/login" method="POST" class="space-y-4">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">Email</label>
                                <div class="relative">
                                    <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                    <input type="email" id="email" name="email"
                                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                                           placeholder="nama@email.com" autocomplete="email" required
                                           class="h-12 w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10">
                                </div>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <label for="password" class="block text-sm font-semibold text-slate-200">Password</label>
                                    <span class="text-xs text-slate-500">Min. 6 karakter</span>
                                </div>
                                <div class="relative">
                                    <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                    <input type="password" id="password" name="password"
                                           placeholder="Masukkan password" autocomplete="current-password" required
                                           class="h-12 w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10">
                                </div>
                            </div>

                            <button type="submit"
                                    class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-emerald-400 px-5 text-sm font-extrabold text-slate-950 transition hover:bg-emerald-300 focus:outline-none focus:ring-4 focus:ring-emerald-400/20 active:scale-[0.99]">
                                Masuk Sekarang
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </form>

                        <p class="mt-6 text-center text-sm text-slate-400">
                            Belum punya akun?
                            <a href="<?php echo BASE_URL; ?>/register" class="font-bold text-emerald-300 transition hover:text-emerald-200">Daftar Manajer</a>
                        </p>
                    </div>
                </div>

                <aside class="border-t border-slate-700/70 bg-slate-900/45 p-5 sm:p-8 lg:border-t-0">
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between lg:block">
                        <div>
                            <p class="mb-2 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-3 py-1 text-xs font-bold text-emerald-300">
                                <i class="bi bi-key-fill"></i>
                                Akun Demo
                            </p>
                            <h1 class="text-2xl font-extrabold text-white">Copy akun pengujian</h1>
                            <p class="mt-2 max-w-md text-sm leading-6 text-slate-400">Klik tombol copy pada email atau password, lalu tempel ke form login di sebelah kiri.</p>
                        </div>
                    </div>

                    <div class="grid max-h-[520px] gap-3 overflow-y-auto pr-1 xl:grid-cols-2">
                        <?php foreach ($demoAccounts as $account): ?>
                        <div class="rounded-2xl border border-slate-700/70 bg-slate-950/65 p-4">
                            <div class="mb-3 flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-extrabold text-white"><?php echo $account['role']; ?></p>
                                    <p class="mt-0.5 truncate text-xs text-slate-500"><?php echo $account['team']; ?></p>
                                </div>
                                <span class="flex-shrink-0 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-2 py-1 text-[10px] font-bold uppercase text-emerald-200">
                                    <?php echo $account['badge']; ?>
                                </span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-2">
                                    <i class="bi bi-envelope text-slate-500"></i>
                                    <span class="min-w-0 flex-1 truncate font-mono text-xs text-slate-300"><?php echo $account['email']; ?></span>
                                    <button type="button" onclick="copyDemoText('<?php echo $account['email']; ?>', this)" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-emerald-300" title="Copy email">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-2">
                                    <i class="bi bi-key text-slate-500"></i>
                                    <span class="min-w-0 flex-1 truncate font-mono text-xs text-slate-300"><?php echo $account['password']; ?></span>
                                    <button type="button" onclick="copyDemoText('<?php echo $account['password']; ?>', this)" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-emerald-300" title="Copy password">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </aside>
            </section>
        </div>
    </main>

    <div id="copy-toast" class="pointer-events-none fixed bottom-5 left-1/2 z-50 hidden -translate-x-1/2 rounded-full border border-emerald-400/30 bg-slate-950 px-4 py-2 text-xs font-bold text-emerald-200 shadow-2xl shadow-black/40">
        Tersalin
    </div>
    <script>
        function copyDemoText(text, button) {
            const done = () => {
                const icon = button.querySelector('i');
                const oldClass = icon.className;
                icon.className = 'bi bi-check2';
                button.classList.add('text-emerald-300');

                const toast = document.getElementById('copy-toast');
                toast.classList.remove('hidden');

                setTimeout(() => {
                    icon.className = oldClass;
                    button.classList.remove('text-emerald-300');
                    toast.classList.add('hidden');
                }, 1200);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done);
                return;
            }

            const input = document.createElement('textarea');
            input.value = text;
            input.style.position = 'fixed';
            input.style.opacity = '0';
            document.body.appendChild(input);
            input.focus();
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            done();
        }
    </script>
</body>
</html>
