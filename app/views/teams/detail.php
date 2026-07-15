<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<!-- Back -->
<div class="mb-5">
    <a href="<?php echo Session::isAdmin() ? BASE_URL . '/teams' : BASE_URL . '/dashboard'; ?>"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Team Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
            <!-- Logo area -->
            <div class="relative h-28 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center border-b border-gray-700/60">
                <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#22c55e 1px, transparent 1px), linear-gradient(90deg, #22c55e 1px, transparent 1px); background-size: 20px 20px;"></div>
                <?php if ($team['logo'] && file_exists('uploads/logos/' . $team['logo'])): ?>
                    <img src="<?php echo BASE_URL . '/uploads/logos/' . htmlspecialchars($team['logo']); ?>"
                         alt="Logo Tim" class="w-24 h-24 rounded-2xl object-cover ring-2 ring-green-500/40 shadow-xl z-10">
                <?php else: ?>
                    <div class="w-24 h-24 rounded-2xl bg-gray-700 flex items-center justify-center text-3xl font-extrabold text-gray-400 z-10 ring-2 ring-gray-600">
                        <?php echo strtoupper(substr($team['team_name'], 0, 2)); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="p-5">
                <h3 class="text-lg font-bold text-white text-center mb-1"><?php echo htmlspecialchars($team['team_name']); ?></h3>
                <p class="text-xs text-gray-500 text-center mb-4">ID Reg: #<?php echo $team['id']; ?></p>

                <div class="text-center mb-5">
                    <?php if ($team['status'] === 'approved'): ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-green-500/15 text-green-300 border border-green-500/30 px-3 py-1.5 rounded-full">
                            <i class="bi bi-check-circle-fill"></i> Approved
                        </span>
                    <?php elseif ($team['status'] === 'pending'): ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-yellow-500/15 text-yellow-300 border border-yellow-500/30 px-3 py-1.5 rounded-full">
                            <i class="bi bi-hourglass-split"></i> Pending
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-red-500/15 text-red-300 border border-red-500/30 px-3 py-1.5 rounded-full">
                            <i class="bi bi-x-circle-fill"></i> Rejected
                        </span>
                    <?php endif; ?>
                </div>

                <div class="space-y-3 border-t border-gray-800 pt-4">
                    <div>
                        <p class="text-[11px] text-gray-600 uppercase tracking-wider mb-0.5">Manajer Tim</p>
                        <p class="text-sm font-semibold text-white"><?php echo htmlspecialchars($team['manager_name']); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($team['manager_email']); ?></p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-600 uppercase tracking-wider mb-0.5">Kontak WA</p>
                        <p class="text-sm text-green-400 font-medium flex items-center gap-1">
                            <i class="bi bi-whatsapp"></i><?php echo htmlspecialchars($team['contact_number']); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-600 uppercase tracking-wider mb-0.5">Tanggal Daftar</p>
                        <p class="text-sm text-gray-400"><?php echo date('d F Y, H:i', strtotime($team['created_at'])); ?></p>
                    </div>
                </div>

                <?php if (Session::isAdmin() || Session::get('user_id') == $team['manager_id']): ?>
                <div class="pt-4 border-t border-gray-800 mt-4">
                    <a href="<?php echo BASE_URL . '/teams/delete/' . $team['id']; ?>"
                       onclick="return confirm('Hapus tim ini beserta semua pemainnya secara permanen?')"
                       class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-red-400 border border-red-500/30 hover:bg-red-500/10 transition-all">
                        <i class="bi bi-trash"></i> Hapus Tim
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Players Roster -->
    <div class="lg:col-span-2">
        <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden h-full">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700/60">
                <h4 class="font-bold text-white flex items-center gap-2">
                    <i class="bi bi-people text-green-400"></i>
                    Roster Pemain <span class="text-gray-500 font-normal text-sm">(<?php echo count($players); ?>)</span>
                </h4>
                <?php if (Session::isManager() && Session::get('user_id') == $team['manager_id'] && $team['status'] === 'approved'): ?>
                <a href="<?php echo BASE_URL; ?>/players/create"
                   class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-gradient-to-r from-green-400 to-emerald-500 px-3 py-1.5 rounded-lg hover:opacity-90 transition-opacity">
                    <i class="bi bi-plus-lg"></i> Tambah
                </a>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-600 w-20">Foto</th>
                            <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-600 w-20">No.</th>
                            <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-600">Nama Pemain</th>
                            <th class="text-left px-5 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-600 hidden sm:table-cell">Posisi</th>
                            <th class="text-right px-5 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-600">Identitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <?php if (empty($players)): ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <i class="bi bi-people text-3xl block mb-2 opacity-40"></i>
                                <p class="text-sm">Roster masih kosong</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($players as $player): ?>
                        <tr class="hover:bg-gray-800/40 transition-colors">
                            <td class="px-5 py-3.5">
                                <?php if (!empty($player['photo']) && file_exists('uploads/photos/' . $player['photo'])): ?>
                                    <img src="<?php echo BASE_URL . '/uploads/photos/' . htmlspecialchars($player['photo']); ?>"
                                         alt="Foto <?php echo htmlspecialchars($player['player_name']); ?>"
                                         class="w-11 h-11 rounded-xl object-cover ring-1 ring-gray-700">
                                <?php else: ?>
                                    <div class="w-11 h-11 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-500">
                                        <i class="bi bi-person"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-xl font-extrabold text-green-400 tabular-nums">#<?php echo $player['jersey_number']; ?></span>
                            </td>
                            <td class="px-5 py-3.5 text-sm font-semibold text-white">
                                <?php echo htmlspecialchars($player['player_name']); ?>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 bg-gray-800 border border-gray-700 px-2.5 py-1 rounded-lg">
                                    <?php echo htmlspecialchars($player['position']); ?>
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <?php if ($player['identity_card'] && file_exists('uploads/identities/' . $player['identity_card'])): ?>
                                    <a href="<?php echo BASE_URL . '/uploads/identities/' . $player['identity_card']; ?>"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 text-xs text-green-400 hover:text-green-300 font-medium transition-colors">
                                        <i class="bi bi-file-earmark-pdf"></i> Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs text-gray-600">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
