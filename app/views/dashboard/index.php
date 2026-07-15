<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<!-- ===== DASHBOARD ===== -->

<!-- Hero Banner -->
<div class="relative overflow-hidden rounded-2xl mb-6 bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700/60 p-6 sm:p-8">
    <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(#22c55e 1px, transparent 1px), linear-gradient(90deg, #22c55e 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="relative flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1 min-w-0">
            <span class="inline-flex items-center gap-1.5 text-[10px] uppercase tracking-widest font-bold text-green-400 bg-green-500/10 border border-green-500/20 px-2.5 py-1 rounded-full mb-3">
                <i class="bi bi-trophy"></i> UAS PWD 2026
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                Halo, <?php echo htmlspecialchars(Session::get('user_name')); ?>! 👋
            </h1>
            <p class="text-gray-400 text-sm mt-1 max-w-lg">Selamat datang di <strong class="text-white">FutsalKit</strong>. Sistem terintegrasi untuk manajemen turnamen & jadwal pertandingan futsal.</p>
        </div>
        <div class="flex-shrink-0 text-right">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Hak Akses</p>
            <span class="inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1.5 rounded-xl <?php echo Session::isAdmin() ? 'bg-green-500/15 text-green-300 border border-green-500/30' : 'bg-blue-500/15 text-blue-300 border border-blue-500/30'; ?>">
                <i class="bi bi-shield-check"></i>
                <?php echo strtoupper(Session::get('user_role')); ?>
            </span>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 <?php echo Session::isAdmin() ? 'lg:grid-cols-4' : 'lg:grid-cols-3'; ?> gap-4 mb-6">
    <?php if (Session::isAdmin()): ?>

    <!-- Admin Stats -->
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 hover:border-green-500/40 transition-all duration-300 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-green-500/15 flex items-center justify-center group-hover:bg-green-500/25 transition-colors">
                <i class="bi bi-shield-shaded text-green-400 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-white mb-1"><?php echo $total_teams; ?></p>
        <p class="text-xs text-gray-500 font-medium">Total Tim Terdaftar</p>
        <a href="<?php echo BASE_URL; ?>/teams" class="mt-3 inline-flex items-center gap-1 text-xs text-green-400 hover:text-green-300 font-medium transition-colors">Kelola Tim <i class="bi bi-arrow-right text-xs"></i></a>
    </div>

    <div class="bg-gray-900 border <?php echo $pending_teams > 0 ? 'border-yellow-500/40 shadow-yellow-500/10 shadow-lg' : 'border-gray-700/60'; ?> rounded-2xl p-5 hover:border-yellow-500/50 transition-all duration-300 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-500/15 flex items-center justify-center group-hover:bg-yellow-500/25 transition-colors">
                <i class="bi bi-clock-history text-yellow-400 text-xl"></i>
            </div>
            <?php if ($pending_teams > 0): ?>
            <span class="text-[10px] font-bold uppercase bg-yellow-500/20 text-yellow-300 px-2 py-0.5 rounded-full animate-pulse">Perlu Aksi</span>
            <?php endif; ?>
        </div>
        <p class="text-3xl font-extrabold <?php echo $pending_teams > 0 ? 'text-yellow-300' : 'text-white'; ?> mb-1"><?php echo $pending_teams; ?></p>
        <p class="text-xs text-gray-500 font-medium">Tim Menunggu Verifikasi</p>
        <a href="<?php echo BASE_URL; ?>/teams" class="mt-3 inline-flex items-center gap-1 text-xs text-yellow-400 hover:text-yellow-300 font-medium transition-colors">Verifikasi <i class="bi bi-arrow-right text-xs"></i></a>
    </div>

    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 hover:border-blue-500/40 transition-all duration-300 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center group-hover:bg-blue-500/25 transition-colors">
                <i class="bi bi-people-fill text-blue-400 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-white mb-1"><?php echo $total_players; ?></p>
        <p class="text-xs text-gray-500 font-medium">Total Pemain Terdaftar</p>
        <span class="mt-3 inline-block text-xs text-gray-600 font-medium">Semua tim</span>
    </div>

    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 hover:border-purple-500/40 transition-all duration-300 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center group-hover:bg-purple-500/25 transition-colors">
                <i class="bi bi-calendar-event text-purple-400 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-extrabold text-white mb-1"><?php echo $total_matches; ?></p>
        <p class="text-xs text-gray-500 font-medium">Total Jadwal Pertandingan</p>
        <a href="<?php echo BASE_URL; ?>/matches" class="mt-3 inline-flex items-center gap-1 text-xs text-purple-400 hover:text-purple-300 font-medium transition-colors">Lihat Jadwal <i class="bi bi-arrow-right text-xs"></i></a>
    </div>

    <?php else: ?>
    <!-- Manager Stats -->
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 col-span-2 lg:col-span-1 hover:border-green-500/40 transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-500/15 flex items-center justify-center flex-shrink-0">
                <i class="bi bi-shield-check text-green-400 text-xl"></i>
            </div>
            <p class="text-sm font-medium text-gray-400">Status Tim</p>
        </div>
        <?php if ($has_team): ?>
            <p class="text-lg font-bold text-white truncate mb-2"><?php echo htmlspecialchars($team['team_name']); ?></p>
            <?php if ($team['status'] === 'approved'): ?>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-green-500/15 text-green-300 border border-green-500/30 px-2.5 py-1 rounded-full"><i class="bi bi-check-circle-fill"></i> Approved</span>
            <?php elseif ($team['status'] === 'pending'): ?>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-yellow-500/15 text-yellow-300 border border-yellow-500/30 px-2.5 py-1 rounded-full"><i class="bi bi-hourglass-split"></i> Pending</span>
            <?php else: ?>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-red-500/15 text-red-300 border border-red-500/30 px-2.5 py-1 rounded-full"><i class="bi bi-x-circle-fill"></i> Rejected</span>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-yellow-400 font-bold mb-2">Belum Terdaftar</p>
            <a href="<?php echo BASE_URL; ?>/teams/register" class="inline-flex items-center gap-1.5 text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-600 text-black px-3 py-1.5 rounded-lg hover:opacity-90 transition-opacity">
                <i class="bi bi-plus-lg"></i> Daftarkan Tim
            </a>
        <?php endif; ?>
    </div>

    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 hover:border-blue-500/40 transition-all duration-300 group">
        <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center mb-3 group-hover:bg-blue-500/25 transition-colors">
            <i class="bi bi-people-fill text-blue-400 text-xl"></i>
        </div>
        <p class="text-3xl font-extrabold text-white mb-1"><?php echo $total_players; ?></p>
        <p class="text-xs text-gray-500 font-medium mb-3">Pemain Tim Saya</p>
        <?php if ($has_team && $team['status'] === 'approved'): ?>
            <a href="<?php echo BASE_URL; ?>/players" class="inline-flex items-center gap-1 text-xs text-blue-400 hover:text-blue-300 font-medium transition-colors">Kelola Roster <i class="bi bi-arrow-right text-xs"></i></a>
        <?php else: ?>
            <span class="text-xs text-gray-600">Belum tersedia</span>
        <?php endif; ?>
    </div>

    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-5 hover:border-purple-500/40 transition-all duration-300 group">
        <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center mb-3 group-hover:bg-purple-500/25 transition-colors">
            <i class="bi bi-calendar-event text-purple-400 text-xl"></i>
        </div>
        <p class="text-3xl font-extrabold text-white mb-1"><?php echo $total_matches; ?></p>
        <p class="text-xs text-gray-500 font-medium mb-3">Jadwal Pertandingan</p>
        <a href="<?php echo BASE_URL; ?>/matches" class="inline-flex items-center gap-1 text-xs text-purple-400 hover:text-purple-300 font-medium transition-colors">Lihat Semua <i class="bi bi-arrow-right text-xs"></i></a>
    </div>
    <?php endif; ?>
</div>

<!-- Bottom Info Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Guide -->
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-6">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
            <i class="bi bi-lightbulb text-yellow-400"></i> Panduan Penggunaan
        </h3>
        <ol class="space-y-3">
            <?php if (Session::isAdmin()): ?>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">1</span>
                    <span class="text-gray-400">Tinjau pendaftaran tim baru di menu <strong class="text-white">Daftar Tim</strong> dan lakukan Approve atau Reject.</span>
                </li>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">2</span>
                    <span class="text-gray-400">Hanya tim berstatus <strong class="text-green-400">Approved</strong> yang bisa didaftarkan ke jadwal pertandingan.</span>
                </li>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">3</span>
                    <span class="text-gray-400">Gunakan menu <strong class="text-white">Jadwal Pertandingan</strong> untuk membuat jadwal dan mengisi skor hasil akhir.</span>
                </li>
            <?php else: ?>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">1</span>
                    <span class="text-gray-400">Daftarkan tim futsal Anda melalui menu <strong class="text-white">Tim Saya</strong> dan tunggu persetujuan Admin.</span>
                </li>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">2</span>
                    <span class="text-gray-400">Setelah disetujui, tambahkan pemain ke roster di menu <strong class="text-white">Pemain</strong> (beserta foto identitas).</span>
                </li>
                <li class="flex gap-3 text-sm">
                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 text-green-400 text-[10px] font-bold flex items-center justify-center mt-0.5">3</span>
                    <span class="text-gray-400">Pantau jadwal dan hasil skor pertandingan tim Anda di menu <strong class="text-white">Jadwal Pertandingan</strong>.</span>
                </li>
            <?php endif; ?>
        </ol>
    </div>

    <!-- Tech Stack -->
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-green-500/5 rounded-full blur-2xl"></div>
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
            <i class="bi bi-code-slash text-green-400"></i> Tentang Sistem
        </h3>
        <p class="text-sm text-gray-400 mb-5 leading-relaxed">FutsalKit dibangun menggunakan arsitektur <strong class="text-white">MVC PHP Native</strong> tanpa framework, dengan keamanan PDO Prepared Statements, validasi server-side, enkripsi password, dan sistem RBAC untuk kepatuhan standar UAS.</p>
        <div class="flex flex-wrap gap-2">
            <?php foreach (['PHP 8 Native MVC','PDO Prepared Stmt','RBAC URL Protection','Server Validation','File Upload','Tailwind CSS v3'] as $badge): ?>
            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-gray-800 border border-gray-700 text-gray-300"><?php echo $badge; ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
