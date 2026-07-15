<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<!-- Back -->
<div class="mb-5">
    <a href="<?php echo BASE_URL; ?>/dashboard" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-gray-900 border border-gray-700/60 rounded-2xl overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 border-b border-gray-700/60 bg-gradient-to-r from-green-500/5 to-transparent">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="bi bi-shield-plus text-green-400"></i> Daftarkan Tim Futsal Baru
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Ajukan pendaftaran tim ke turnamen FutsalKit. Status awal: <span class="text-yellow-400 font-medium">Pending</span> (menunggu persetujuan Admin)</p>
        </div>

        <!-- Form -->
        <form action="<?php echo BASE_URL; ?>/teams/register" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">

            <div>
                <label for="team_name" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Nama Tim Futsal <span class="text-red-400">*</span>
                </label>
                <input type="text" id="team_name" name="team_name"
                       value="<?php echo isset($team_name) ? htmlspecialchars($team_name) : ''; ?>"
                       placeholder="Contoh: FC Barcelona Futsal" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                <p class="text-xs text-gray-600 mt-1.5">Nama harus unik dan mencerminkan identitas tim.</p>
            </div>

            <div>
                <label for="contact_number" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Nomor Kontak / WhatsApp <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <i class="bi bi-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-green-500 text-sm"></i>
                    <input type="text" id="contact_number" name="contact_number"
                           value="<?php echo isset($contact_number) ? htmlspecialchars($contact_number) : ''; ?>"
                           placeholder="Contoh: 081234567890" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 pl-10 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-colors">
                </div>
            </div>

            <!-- File Upload -->
            <div>
                <label for="logo" class="block text-sm font-semibold text-gray-300 mb-1.5">
                    Logo Tim <span class="text-gray-500 font-normal">(Opsional)</span>
                </label>
                <label for="logo" class="flex flex-col items-center justify-center w-full h-32 bg-gray-800 border-2 border-dashed border-gray-700 rounded-xl cursor-pointer hover:border-green-500/50 hover:bg-gray-800/80 transition-all group">
                    <i class="bi bi-cloud-upload text-3xl text-gray-600 group-hover:text-green-400 transition-colors mb-2"></i>
                    <p class="text-sm text-gray-500 group-hover:text-gray-400">Klik untuk pilih file</p>
                    <p class="text-xs text-gray-600 mt-1">JPG, JPEG, PNG, atau PDF • Maks 2MB</p>
                    <input id="logo" name="logo" type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf"
                           onchange="document.getElementById('logo-label').textContent = this.files[0]?.name || 'Pilih file'">
                </label>
                <p id="logo-label" class="text-xs text-gray-600 mt-1.5 text-center truncate"></p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-800">
                <span class="text-xs text-gray-600"><span class="text-red-400">*</span> Wajib diisi</span>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-sm text-black bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-300 hover:to-emerald-400 transition-all duration-200 shadow-lg shadow-green-500/20 hover:-translate-y-0.5 active:translate-y-0">
                    Daftarkan Tim <i class="bi bi-send"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
