<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="mb-5">
    <a href="<?php echo BASE_URL; ?>/players" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Roster
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-700/60 bg-gradient-to-r from-yellow-500/5 to-transparent">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-pencil-square text-yellow-400"></i> Edit Data Pemain
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi pemain. Berkas lama dipertahankan kecuali diunggah yang baru.</p>
        </div>

        <form action="<?php echo BASE_URL; ?>/players/edit/<?php echo $player['id']; ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">

            <div>
                <label for="player_name" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Nama Lengkap Pemain <span class="text-red-400">*</span>
                </label>
                <input type="text" id="player_name" name="player_name"
                       value="<?php echo htmlspecialchars($player['player_name']); ?>"
                       placeholder="Nama pemain" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="jersey_number" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        No Punggung <span class="text-red-400">*</span>
                    </label>
                    <input type="number" id="jersey_number" name="jersey_number" min="1" max="99"
                           value="<?php echo htmlspecialchars($player['jersey_number']); ?>"
                           required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                    <p class="text-xs text-gray-600 mt-1">Tidak boleh kembar di satu tim</p>
                </div>
                <div>
                    <label for="position" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        Posisi <span class="text-red-400">*</span>
                    </label>
                    <select id="position" name="position" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <?php foreach (['Kiper - Inti', 'Anchor - Inti', 'Flank Kanan - Inti', 'Flank Kiri - Inti', 'Pivot - Inti', 'Kiper - Cadangan', 'Anchor - Cadangan', 'Flank Kanan - Cadangan', 'Flank Kiri - Cadangan', 'Pivot - Cadangan'] as $option): ?>
                            <option value="<?php echo $option; ?>" <?php echo ($player['position'] === $option) ? 'selected' : ''; ?>>
                                <?php echo $option; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Perbarui Berkas Identitas <span class="text-gray-500 font-normal">(Opsional)</span>
                </label>
                <?php if ($player['identity_card'] && file_exists('uploads/identities/' . $player['identity_card'])): ?>
                <div class="flex items-center gap-3 p-3 bg-gray-800 border border-gray-700 rounded-xl mb-3">
                    <i class="bi bi-file-earmark-check text-green-400 text-xl flex-shrink-0"></i>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 mb-0.5">Berkas saat ini:</p>
                        <a href="<?php echo BASE_URL . '/uploads/identities/' . $player['identity_card']; ?>"
                           target="_blank" class="text-sm text-green-400 hover:text-green-300 truncate block transition-colors">
                            <?php echo htmlspecialchars($player['identity_card']); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <label for="identity_card" class="flex flex-col items-center justify-center w-full h-24 bg-gray-800 border-2 border-dashed border-gray-700 rounded-xl cursor-pointer hover:border-green-500/50 transition-all group">
                    <i class="bi bi-cloud-upload text-2xl text-gray-600 group-hover:text-green-400 transition-colors mb-1"></i>
                    <p class="text-xs text-gray-500">Klik untuk mengganti berkas • JPG, PNG, PDF • Maks 2MB</p>
                    <input id="identity_card" name="identity_card" type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf"
                           onchange="document.getElementById('edit-id-label').textContent = this.files[0]?.name || ''">
                </label>
                <p id="edit-id-label" class="text-xs text-gray-500 mt-1.5 text-center truncate"></p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Perbarui Foto Pemain <span class="text-gray-500 font-normal">(Opsional)</span>
                </label>
                <?php if (!empty($player['photo']) && file_exists('uploads/photos/' . $player['photo'])): ?>
                <div class="flex items-center gap-3 p-3 bg-gray-800 border border-gray-700 rounded-xl mb-3">
                    <img src="<?php echo BASE_URL . '/uploads/photos/' . htmlspecialchars($player['photo']); ?>"
                         alt="Foto Pemain" class="w-14 h-14 rounded-xl object-cover ring-1 ring-gray-700">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 mb-0.5">Foto saat ini:</p>
                        <p class="text-sm text-gray-300 truncate"><?php echo htmlspecialchars($player['photo']); ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <label for="photo" class="flex flex-col items-center justify-center w-full h-24 bg-gray-800 border-2 border-dashed border-gray-700 rounded-xl cursor-pointer hover:border-green-500/50 transition-all group">
                    <i class="bi bi-camera text-2xl text-gray-600 group-hover:text-green-400 transition-colors mb-1"></i>
                    <p class="text-xs text-gray-500">Klik untuk mengganti foto • JPG, PNG • Maks 2MB</p>
                    <input id="photo" name="photo" type="file" class="hidden" accept=".jpg,.jpeg,.png"
                           onchange="document.getElementById('edit-photo-label').textContent = this.files[0]?.name || ''">
                </label>
                <p id="edit-photo-label" class="text-xs text-gray-500 mt-1.5 text-center truncate"></p>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-gray-800">
                <span class="text-xs text-gray-600"><span class="text-red-400">*</span> Wajib diisi</span>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-sm text-black bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-300 hover:to-emerald-400 transition-all duration-200 shadow-lg shadow-green-500/20 hover:-translate-y-0.5 active:translate-y-0">
                    Simpan Perubahan <i class="bi bi-save"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
