<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <i class="bi bi-people-fill text-green-400"></i> Roster Pemain
        </h2>
        <p class="text-sm text-gray-500 mt-1">Tim: <span class="text-white font-semibold"><?php echo htmlspecialchars($team['team_name']); ?></span></p>
    </div>
    <a href="<?php echo BASE_URL; ?>/players/create"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm text-black bg-gradient-to-r from-green-400 to-emerald-500 hover:opacity-90 transition-all hover:-translate-y-0.5 shadow-lg shadow-green-500/20">
        <i class="bi bi-person-plus-fill"></i> Tambah Pemain Baru
    </a>
</div>

<div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700/60">
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 w-20">Foto</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 w-24">No Punggung</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Nama Pemain</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 hidden sm:table-cell">Posisi</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 hidden md:table-cell">Berkas Identitas</th>
                    <th class="text-right px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                <?php if (empty($players)): ?>
                <tr>
                    <td colspan="6" class="py-16 text-center text-gray-500">
                        <i class="bi bi-people-fill text-4xl block mb-3 opacity-30"></i>
                        <p class="font-medium mb-1">Roster pemain masih kosong</p>
                        <a href="<?php echo BASE_URL; ?>/players/create"
                           class="inline-flex items-center gap-1.5 text-sm text-green-400 hover:text-green-300 font-semibold mt-2 transition-colors">
                            <i class="bi bi-plus-circle"></i> Tambahkan Pemain Pertama
                        </a>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($players as $player): ?>
                <tr class="hover:bg-gray-800/50 transition-colors group">
                    <td class="px-5 py-4">
                        <?php if (!empty($player['photo']) && file_exists('uploads/photos/' . $player['photo'])): ?>
                            <img src="<?php echo BASE_URL . '/uploads/photos/' . htmlspecialchars($player['photo']); ?>"
                                 alt="Foto <?php echo htmlspecialchars($player['player_name']); ?>"
                                 class="w-12 h-12 rounded-xl object-cover ring-1 ring-gray-700">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-500">
                                <i class="bi bi-person"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-2xl font-extrabold text-green-400 tabular-nums">#<?php echo $player['jersey_number']; ?></span>
                    </td>
                    <td class="px-5 py-4 text-sm font-semibold text-white">
                        <?php echo htmlspecialchars($player['player_name']); ?>
                    </td>
                    <td class="px-5 py-4 hidden sm:table-cell">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 bg-gray-800 border border-gray-700 px-2.5 py-1 rounded-lg">
                            <?php echo htmlspecialchars($player['position']); ?>
                        </span>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <?php if ($player['identity_card'] && file_exists('uploads/identities/' . $player['identity_card'])): ?>
                            <a href="<?php echo BASE_URL . '/uploads/identities/' . $player['identity_card']; ?>"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs font-medium text-green-400 hover:text-green-300 transition-colors bg-green-500/10 border border-green-500/20 px-2.5 py-1.5 rounded-lg">
                                <i class="bi bi-file-earmark-pdf"></i> Lihat Berkas
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-600 flex items-center gap-1">
                                <i class="bi bi-x-circle text-red-500/50"></i> Belum diunggah
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="<?php echo BASE_URL . '/players/edit/' . $player['id']; ?>"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-yellow-500/15 hover:text-yellow-400 transition-all" title="Edit Pemain">
                                <i class="bi bi-pencil-square text-sm"></i>
                            </a>
                            <a href="<?php echo BASE_URL . '/players/delete/' . $player['id']; ?>"
                               onclick="return confirm('Hapus pemain ini secara permanen?')"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-red-500/15 hover:text-red-400 transition-all" title="Hapus Pemain">
                                <i class="bi bi-trash text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
