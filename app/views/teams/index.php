<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <i class="bi bi-shield-shaded text-green-400"></i> Daftar Pendaftaran Tim
        </h2>
        <p class="text-sm text-gray-500 mt-1">Verifikasi dan kelola semua tim futsal yang mendaftar</p>
    </div>
    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 bg-gray-800 border border-gray-700 px-3 py-1.5 rounded-full">
        <i class="bi bi-collection"></i> <?php echo count($teams); ?> Tim Terdaftar
    </span>
</div>

<!-- Table Card -->
<div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700/60">
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 w-16">Logo</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Nama Tim</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 hidden md:table-cell">Manajer</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 hidden lg:table-cell">Kontak</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500 hidden lg:table-cell">Tanggal Daftar</th>
                    <th class="text-left px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    <th class="text-right px-5 py-4 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                <?php if (empty($teams)): ?>
                <tr>
                    <td colspan="7" class="text-center py-16 text-gray-500">
                        <i class="bi bi-shield-slash text-4xl block mb-3 opacity-50"></i>
                        <p class="font-medium">Belum ada tim yang mendaftar</p>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($teams as $team): ?>
                <tr class="hover:bg-gray-800/50 transition-colors duration-150 group">
                    <td class="px-5 py-4">
                        <?php if ($team['logo'] && file_exists('uploads/logos/' . $team['logo'])): ?>
                            <img src="<?php echo BASE_URL . '/uploads/logos/' . htmlspecialchars($team['logo']); ?>"
                                 alt="Logo" class="w-10 h-10 rounded-xl object-cover ring-1 ring-gray-700">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-xl bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-300">
                                <?php echo strtoupper(substr($team['team_name'], 0, 2)); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <a href="<?php echo BASE_URL . '/teams/detail/' . $team['id']; ?>"
                           class="font-semibold text-white group-hover:text-green-400 transition-colors text-sm">
                            <?php echo htmlspecialchars($team['team_name']); ?>
                        </a>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <p class="text-sm text-white font-medium"><?php echo htmlspecialchars($team['manager_name']); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($team['manager_email']); ?></p>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-sm text-gray-400">
                        <i class="bi bi-whatsapp text-green-500 me-1"></i><?php echo htmlspecialchars($team['contact_number']); ?>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-sm text-gray-500">
                        <?php echo date('d M Y', strtotime($team['created_at'])); ?>
                    </td>
                    <td class="px-5 py-4">
                        <?php if ($team['status'] === 'approved'): ?>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold bg-green-500/15 text-green-300 border border-green-500/30 px-2.5 py-1 rounded-full">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        <?php elseif ($team['status'] === 'pending'): ?>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold bg-yellow-500/15 text-yellow-300 border border-yellow-500/30 px-2.5 py-1 rounded-full">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold bg-red-500/15 text-red-300 border border-red-500/30 px-2.5 py-1 rounded-full">
                                <i class="bi bi-x-circle-fill"></i> Rejected
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="<?php echo BASE_URL . '/teams/detail/' . $team['id']; ?>"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-blue-500/15 hover:text-blue-400 transition-all" title="Detail Tim">
                                <i class="bi bi-eye text-sm"></i>
                            </a>
                            <?php if ($team['status'] === 'pending'): ?>
                            <a href="<?php echo BASE_URL . '/teams/approve/' . $team['id']; ?>"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-green-500/15 hover:text-green-400 transition-all" title="Approve Tim">
                                <i class="bi bi-check-lg text-sm"></i>
                            </a>
                            <a href="<?php echo BASE_URL . '/teams/reject/' . $team['id']; ?>"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-yellow-500/15 hover:text-yellow-400 transition-all" title="Reject Tim">
                                <i class="bi bi-x-lg text-sm"></i>
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo BASE_URL . '/teams/delete/' . $team['id']; ?>"
                               onclick="return confirm('Hapus tim ini beserta semua pemainnya secara permanen?')"
                               class="p-1.5 rounded-lg bg-gray-800 text-gray-400 hover:bg-red-500/15 hover:text-red-400 transition-all" title="Hapus Tim">
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
