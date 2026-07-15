<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="mb-5">
    <a href="<?php echo BASE_URL; ?>/matches" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Jadwal
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-700/60 bg-gradient-to-r from-yellow-500/5 to-transparent">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-pencil-square text-yellow-400"></i> Edit Jadwal & Input Skor
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Perbarui detail pertandingan. Isi kolom skor hanya jika status berubah menjadi <span class="text-green-400 font-semibold">Finished</span>.</p>
        </div>

        <form action="<?php echo BASE_URL; ?>/matches/edit/<?php echo $match['id']; ?>" method="POST" class="p-6 space-y-5">

            <div>
                <label for="tournament_name" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Nama Turnamen / Event <span class="text-red-400">*</span>
                </label>
                <input type="text" id="tournament_name" name="tournament_name"
                       value="<?php echo htmlspecialchars($match['tournament_name']); ?>" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="home_team_id" class="block text-sm font-semibold text-gray-300 mb-1.5">Tim Kandang <span class="text-red-400">*</span></label>
                    <select id="home_team_id" name="home_team_id" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['id']; ?>" <?php echo ($match['home_team_id'] == $team['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($team['team_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="away_team_id" class="block text-sm font-semibold text-gray-300 mb-1.5">Tim Tandang <span class="text-red-400">*</span></label>
                    <select id="away_team_id" name="away_team_id" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['id']; ?>" <?php echo ($match['away_team_id'] == $team['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($team['team_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="match_date" class="block text-sm font-semibold text-gray-300 mb-1.5">Tanggal <span class="text-red-400">*</span></label>
                    <input type="date" id="match_date" name="match_date"
                           value="<?php echo htmlspecialchars($match['match_date']); ?>" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
                <div>
                    <label for="match_time" class="block text-sm font-semibold text-gray-300 mb-1.5">Waktu <span class="text-red-400">*</span></label>
                    <input type="time" id="match_time" name="match_time"
                           value="<?php echo htmlspecialchars($match['match_time']); ?>" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
            </div>

            <div>
                <label for="venue" class="block text-sm font-semibold text-gray-300 mb-1.5">Lokasi / Venue <span class="text-red-400">*</span></label>
                <div class="relative">
                    <i class="bi bi-geo-alt-fill absolute left-3.5 top-1/2 -translate-y-1/2 text-red-500/70 text-sm"></i>
                    <input type="text" id="venue" name="venue"
                           value="<?php echo htmlspecialchars($match['venue']); ?>" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
            </div>

            <!-- Status & Score Section -->
            <div class="p-4 bg-gray-800/60 border border-gray-700 rounded-xl space-y-4">
                <h4 class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="bi bi-flag-fill text-green-400"></i> Status & Skor Pertandingan
                </h4>

                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-300 mb-1.5">Status <span class="text-red-400">*</span></label>
                    <select id="status" name="status" onchange="toggleScore()" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                        <option value="scheduled" <?php echo ($match['status'] === 'scheduled') ? 'selected' : ''; ?>>Scheduled (Terjadwal)</option>
                        <option value="ongoing"   <?php echo ($match['status'] === 'ongoing')   ? 'selected' : ''; ?>>Ongoing / Live</option>
                        <option value="finished"  <?php echo ($match['status'] === 'finished')  ? 'selected' : ''; ?>>Finished (Selesai)</option>
                    </select>
                </div>

                <div id="score-section" class="grid grid-cols-2 gap-4 <?php echo ($match['status'] !== 'finished') ? 'opacity-40' : ''; ?> transition-opacity duration-300">
                    <div>
                        <label for="score_home" class="block text-sm font-semibold text-gray-300 mb-1.5">
                            Skor Kandang
                        </label>
                        <input type="number" id="score_home" name="score_home" min="0"
                               value="<?php echo ($match['score_home'] !== null) ? htmlspecialchars($match['score_home']) : ''; ?>"
                               placeholder="0" <?php echo ($match['status'] !== 'finished') ? 'disabled' : ''; ?>
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm text-center font-bold text-2xl focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                    </div>
                    <div>
                        <label for="score_away" class="block text-sm font-semibold text-gray-300 mb-1.5">
                            Skor Tandang
                        </label>
                        <input type="number" id="score_away" name="score_away" min="0"
                               value="<?php echo ($match['score_away'] !== null) ? htmlspecialchars($match['score_away']) : ''; ?>"
                               placeholder="0" <?php echo ($match['status'] !== 'finished') ? 'disabled' : ''; ?>
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm text-center font-bold text-2xl focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                    </div>
                </div>
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

<script>
function toggleScore() {
    const status = document.getElementById('status').value;
    const section = document.getElementById('score-section');
    const inputs = section.querySelectorAll('input');
    const isFinished = status === 'finished';

    section.style.opacity = isFinished ? '1' : '0.4';
    inputs.forEach(inp => {
        if (isFinished) {
            inp.removeAttribute('disabled');
            inp.setAttribute('required', '');
        } else {
            inp.setAttribute('disabled', '');
            inp.removeAttribute('required');
        }
    });
}
document.addEventListener('DOMContentLoaded', toggleScore);
</script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
