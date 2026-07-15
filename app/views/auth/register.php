<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | FutsalKit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pitch: '#0b1220',
                        panel: '#111827',
                        line: '#334155',
                        neon: '#22c55e'
                    },
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
        .field-marking {
            background:
                linear-gradient(90deg, transparent calc(50% - 1px), rgba(34, 197, 94, 0.26) calc(50% - 1px), rgba(34, 197, 94, 0.26) calc(50% + 1px), transparent calc(50% + 1px));
        }
    </style>
</head>
<body class="min-h-screen text-slate-100 antialiased">
    <main class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 pitch-lines opacity-70"></div>
        <div class="absolute inset-x-6 top-6 bottom-6 hidden rounded-[28px] border border-slate-700/50 field-marking md:block"></div>

        <div class="relative mx-auto flex min-h-screen w-full max-w-6xl items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <section class="grid w-full overflow-hidden rounded-[28px] border border-slate-700/70 bg-slate-950/80 shadow-2xl shadow-black/40 backdrop-blur md:grid-cols-[1fr_460px]">
                <div class="hidden min-h-[680px] flex-col justify-between border-r border-slate-700/70 bg-slate-900/60 p-8 md:flex lg:p-10">
                    <div>
                        <a href="<?php echo BASE_URL; ?>/login" class="inline-flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-400 text-slate-950 shadow-lg shadow-emerald-500/20">
                                <i class="bi bi-dribbble text-2xl"></i>
                            </span>
                            <span>
                                <span class="block text-2xl font-extrabold text-white">FutsalKit</span>
                                <span class="block text-xs font-semibold uppercase text-emerald-300">Tournament Manager</span>
                            </span>
                        </a>

                        <div class="mt-16 max-w-md">
                            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-cyan-300/30 bg-cyan-300/10 px-3 py-1 text-xs font-bold text-cyan-200">
                                <i class="bi bi-person-plus-fill"></i>
                                Manager Registration
                            </p>
                            <h1 class="text-4xl font-extrabold leading-tight text-white lg:text-5xl">Bangun tim dan masuk ke kompetisi.</h1>
                            <p class="mt-5 max-w-sm text-sm leading-6 text-slate-400">Akun baru dibuat sebagai manager, lalu Anda dapat mendaftarkan tim futsal untuk diverifikasi admin.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-700/70 bg-slate-950/55 p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-400/10 text-emerald-300">
                                <i class="bi bi-1-circle-fill"></i>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-white">Buat akun manager</p>
                                <p class="text-xs text-slate-500">Isi nama, email, dan password.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-700/70 bg-slate-950/55 p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-300/10 text-cyan-200">
                                <i class="bi bi-2-circle-fill"></i>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-white">Daftarkan tim</p>
                                <p class="text-xs text-slate-500">Lengkapi data tim setelah login.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-700/70 bg-slate-950/55 p-4">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-300/10 text-violet-200">
                                <i class="bi bi-3-circle-fill"></i>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-white">Tunggu approval</p>
                                <p class="text-xs text-slate-500">Admin memvalidasi sebelum roster aktif.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex min-h-[680px] items-center bg-slate-950 p-5 sm:p-8">
                    <div class="mx-auto w-full max-w-sm">
                        <div class="mb-8 md:hidden">
                            <a href="<?php echo BASE_URL; ?>/login" class="inline-flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-slate-950">
                                    <i class="bi bi-dribbble text-xl"></i>
                                </span>
                                <span>
                                    <span class="block text-xl font-extrabold text-white">FutsalKit</span>
                                    <span class="block text-xs font-semibold uppercase text-emerald-300">Tournament Manager</span>
                                </span>
                            </a>
                        </div>

                        <div class="mb-7">
                            <p class="mb-2 text-sm font-semibold text-cyan-200">Akun manager baru</p>
                            <h2 class="text-3xl font-extrabold text-white">Daftar Akun</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-400">Lengkapi data berikut untuk membuat akses manager.</p>
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

                        <form action="<?php echo BASE_URL; ?>/register" method="POST" class="space-y-4">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-200">Nama Lengkap</label>
                                <div class="relative">
                                    <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                    <input type="text" id="name" name="name"
                                           value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                                           placeholder="Nama lengkap Anda" autocomplete="name" required
                                           class="h-12 w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10">
                                </div>
                            </div>

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
                                           placeholder="Buat password" autocomplete="new-password" required
                                           class="h-12 w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10">
                                </div>
                            </div>

                            <div>
                                <label for="confirm_password" class="mb-2 block text-sm font-semibold text-slate-200">Konfirmasi Password</label>
                                <div class="relative">
                                    <i class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                           placeholder="Ulangi password" autocomplete="new-password" required
                                           class="h-12 w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/10">
                                </div>
                            </div>

                            <button type="submit"
                                    class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-emerald-400 px-5 text-sm font-extrabold text-slate-950 transition hover:bg-emerald-300 focus:outline-none focus:ring-4 focus:ring-emerald-400/20 active:scale-[0.99]">
                                Buat Akun
                                <i class="bi bi-person-plus"></i>
                            </button>
                        </form>

                        <p class="mt-6 text-center text-sm text-slate-400">
                            Sudah punya akun?
                            <a href="<?php echo BASE_URL; ?>/login" class="font-bold text-emerald-300 transition hover:text-emerald-200">Login</a>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
