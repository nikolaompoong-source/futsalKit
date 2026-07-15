<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <i class="bi bi-calendar-event text-green-400"></i> Jadwal & Hasil Pertandingan
        </h2>
        <p class="text-sm text-gray-500 mt-1">Pantau jadwal tanding dan hasil skor akhir turnamen</p>
    </div>
    <?php if (Session::isAdmin()): ?>
    <a href="<?php echo BASE_URL; ?>/matches/create"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm text-black bg-gradient-to-r from-green-400 to-emerald-500 hover:opacity-90 transition-all hover:-translate-y-0.5 shadow-lg shadow-green-500/20 flex-shrink-0">
        <i class="bi bi-plus-lg"></i> Buat Jadwal Baru
    </a>
    <?php endif; ?>
</div>

<?php if (empty($matches)): ?>
<div class="bg-gray-900 border border-gray-700/60 rounded-2xl py-20 text-center text-gray-500">
    <i class="bi bi-calendar-x text-5xl block mb-4 opacity-30"></i>
    <p class="font-semibold text-lg mb-2">Belum ada jadwal pertandingan</p>
    <?php if (Session::isAdmin()): ?>
    <a href="<?php echo BASE_URL; ?>/matches/create"
       class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-black bg-gradient-to-r from-green-400 to-emerald-500 px-4 py-2 rounded-xl hover:opacity-90 transition-opacity">
        <i class="bi bi-plus-lg"></i> Buat Jadwal Pertama
    </a>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    <?php foreach ($matches as $match): ?>
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden hover:border-gray-600 transition-all duration-300 group flex flex-col">

        <!-- Match header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-800 bg-gray-800/40">
            <span class="text-xs font-bold text-green-400 truncate flex items-center gap-1.5">
                <i class="bi bi-trophy-fill text-[10px]"></i>
                <?php echo htmlspecialchars($match['tournament_name']); ?>
            </span>
            <?php if ($match['status'] === 'finished'): ?>
                <span class="flex-shrink-0 text-[10px] font-bold uppercase bg-green-500/15 text-green-300 border border-green-500/30 px-2 py-0.5 rounded-full">
                    <i class="bi bi-check-circle-fill me-0.5"></i>Finished
                </span>
            <?php elseif ($match['status'] === 'ongoing'): ?>
                <span class="flex-shrink-0 text-[10px] font-bold uppercase bg-red-500/15 text-red-300 border border-red-500/30 px-2 py-0.5 rounded-full animate-pulse">
                    <i class="bi bi-broadcast me-0.5"></i>Live
                </span>
            <?php else: ?>
                <span class="flex-shrink-0 text-[10px] font-bold uppercase bg-yellow-500/15 text-yellow-300 border border-yellow-500/30 px-2 py-0.5 rounded-full">
                    <i class="bi bi-calendar-event me-0.5"></i>Scheduled
                </span>
            <?php endif; ?>
        </div>

        <!-- Teams + Score -->
        <div class="flex items-center px-4 py-5 gap-3 flex-1">
            <!-- Home team -->
            <div class="flex-1 text-center min-w-0">
                <?php if ($match['home_team_logo'] && file_exists('uploads/logos/' . $match['home_team_logo'])): ?>
                    <img src="<?php echo BASE_URL . '/uploads/logos/' . htmlspecialchars($match['home_team_logo']); ?>"
                         alt="" class="w-14 h-14 rounded-xl object-cover mx-auto mb-2 ring-1 ring-gray-700">
                <?php else: ?>
                    <div class="w-14 h-14 rounded-xl bg-gray-700 flex items-center justify-center text-lg font-extrabold text-gray-400 mx-auto mb-2">
                        <?php echo strtoupper(substr($match['home_team_name'], 0, 2)); ?>
                    </div>
                <?php endif; ?>
                <p class="text-xs font-bold text-white truncate px-1"><?php echo htmlspecialchars($match['home_team_name']); ?></p>
                <p class="text-[10px] text-gray-600 mt-0.5">Kandang</p>
            </div>

            <!-- Score / VS -->
            <div class="flex-shrink-0 text-center px-2">
                <?php if ($match['status'] === 'finished'): ?>
                    <div class="flex items-center gap-2">
                        <span class="text-3xl font-black text-white tabular-nums"><?php echo $match['score_home']; ?></span>
                        <span class="text-gray-600 text-lg font-bold">:</span>
                        <span class="text-3xl font-black text-white tabular-nums"><?php echo $match['score_away']; ?></span>
                    </div>
                    <p class="text-[10px] text-gray-600 mt-1 uppercase tracking-wider">Final Score</p>
                <?php else: ?>
                    <div class="w-10 h-10 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center">
                        <span class="text-xs font-black text-gray-400">VS</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Away team -->
            <div class="flex-1 text-center min-w-0">
                <?php if ($match['away_team_logo'] && file_exists('uploads/logos/' . $match['away_team_logo'])): ?>
                    <img src="<?php echo BASE_URL . '/uploads/logos/' . htmlspecialchars($match['away_team_logo']); ?>"
                         alt="" class="w-14 h-14 rounded-xl object-cover mx-auto mb-2 ring-1 ring-gray-700">
                <?php else: ?>
                    <div class="w-14 h-14 rounded-xl bg-gray-700 flex items-center justify-center text-lg font-extrabold text-gray-400 mx-auto mb-2">
                        <?php echo strtoupper(substr($match['away_team_name'], 0, 2)); ?>
                    </div>
                <?php endif; ?>
                <p class="text-xs font-bold text-white truncate px-1"><?php echo htmlspecialchars($match['away_team_name']); ?></p>
                <p class="text-[10px] text-gray-600 mt-0.5">Tandang</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-800 flex items-center justify-between gap-2">
            <div class="min-w-0">
                <p class="text-xs text-gray-500 flex items-center gap-1 truncate">
                    <i class="bi bi-calendar3 flex-shrink-0"></i>
                    <?php echo date('d M Y', strtotime($match['match_date'])) . ' • ' . date('H:i', strtotime($match['match_time'])); ?> WIB
                </p>
                <p class="text-xs text-gray-600 flex items-center gap-1 truncate mt-0.5">
                    <i class="bi bi-geo-alt-fill text-red-500/70 flex-shrink-0"></i>
                    <?php echo htmlspecialchars($match['venue']); ?>
                </p>
            </div>
            <?php if (Session::isAdmin()): ?>
            <div class="flex items-center gap-1 flex-shrink-0">
                <a href="<?php echo BASE_URL . '/matches/edit/' . $match['id']; ?>"
                   class="p-1.5 rounded-lg bg-gray-800 text-gray-500 hover:text-yellow-400 hover:bg-yellow-500/15 transition-all" title="Edit / Input Skor">
                    <i class="bi bi-pencil-square text-sm"></i>
                </a>
                <a href="<?php echo BASE_URL . '/matches/delete/' . $match['id']; ?>"
                   onclick="return confirm('Hapus jadwal pertandingan ini?')"
                   class="p-1.5 rounded-lg bg-gray-800 text-gray-500 hover:text-red-400 hover:bg-red-500/15 transition-all" title="Hapus">
                    <i class="bi bi-trash text-sm"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
