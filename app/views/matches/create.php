<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="mb-5">
    <a href="<?php echo BASE_URL; ?>/matches" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Jadwal
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-700/60 bg-gradient-to-r from-green-500/5 to-transparent">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-calendar-plus text-green-400"></i> Buat Jadwal Pertandingan Baru
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Hanya tim berstatus <span class="text-green-400 font-semibold">Approved</span> yang tersedia dalam pilihan tim.</p>
        </div>

        <form action="<?php echo BASE_URL; ?>/matches/create" method="POST" class="p-6 space-y-5">

            <div>
                <label for="tournament_name" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Nama Turnamen / Event <span class="text-red-400">*</span>
                </label>
                <input type="text" id="tournament_name" name="tournament_name"
                       value="<?php echo isset($tournament_name) ? htmlspecialchars($tournament_name) : ''; ?>"
                       placeholder="Contoh: Piala Rektor Futsal 2026" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="home_team_id" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        Tim Kandang (Home) <span class="text-red-400">*</span>
                    </label>
                    <select id="home_team_id" name="home_team_id" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <option value="" disabled selected>-- Pilih Tim Home --</option>
                        <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['id']; ?>" <?php echo (isset($home_team_id) && $home_team_id == $team['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($team['team_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="away_team_id" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        Tim Tandang (Away) <span class="text-red-400">*</span>
                    </label>
                    <select id="away_team_id" name="away_team_id" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <option value="" disabled selected>-- Pilih Tim Away --</option>
                        <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['id']; ?>" <?php echo (isset($away_team_id) && $away_team_id == $team['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($team['team_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="match_date" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        Tanggal <span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="match_date" name="match_date"
                           value="<?php echo isset($match_date) ? htmlspecialchars($match_date) : ''; ?>"
                           required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
                <div>
                    <label for="match_time" class="block text-sm font-semibold text-gray-300 mb-1.5">
                        Waktu <span class="text-red-400">*</span>
                    </label>
                    <input type="time" id="match_time" name="match_time"
                           value="<?php echo isset($match_time) ? htmlspecialchars($match_time) : ''; ?>"
                           required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
            </div>

            <div>
                <label for="venue" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Lokasi / Venue <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <i class="bi bi-geo-alt-fill absolute left-3.5 top-1/2 -translate-y-1/2 text-red-500/70 text-sm"></i>
                    <input type="text" id="venue" name="venue"
                           value="<?php echo isset($venue) ? htmlspecialchars($venue) : ''; ?>"
                           placeholder="Contoh: GOR Futsal Utama" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-gray-800">
                <span class="text-xs text-gray-600"><span class="text-red-400">*</span> Wajib diisi</span>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-sm text-black bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-300 hover:to-emerald-400 transition-all duration-200 shadow-lg shadow-green-500/20 hover:-translate-y-0.5 active:translate-y-0">
                    Simpan Jadwal <i class="bi bi-save"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
