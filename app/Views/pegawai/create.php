<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card" style="max-width: 800px; margin: 0 auto;">
    <div class="mb-4">
        <a href="<?= base_url('pegawai') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius: 8px;">
            <i data-lucide="arrow-left" class="me-1"></i> Kembali
        </a>
        <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Tambah Pegawai Baru</h5>
        <p class="text-muted m-0" style="font-size: 13px;">Masukkan data lengkap pegawai di bawah ini.</p>
    </div>

    <form action="<?= base_url('pegawai/store') ?>" method="POST">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="nip" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" name="nip" id="nip" class="form-control form-control-premium" placeholder="Contoh: 199001012015011001" required autocomplete="off">
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nama Lengkap (beserta Gelar)</label>
                    <input type="text" name="nama" id="nama" class="form-control form-control-premium" placeholder="Contoh: Ahmad Wahyudi, S.Kom." required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="pangkat" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Pangkat</label>
                    <input type="text" name="pangkat" id="pangkat" class="form-control form-control-premium" placeholder="Contoh: Penata" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="golongan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Golongan Ruang</label>
                    <input type="text" name="golongan" id="golongan" class="form-control form-control-premium" placeholder="Contoh: III/c" required autocomplete="off">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="jabatan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Jabatan Struktural / Fungsional</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control form-control-premium" placeholder="Contoh: Pranata Komputer Ahli Muda" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="unit_kerja" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Unit Kerja</label>
                    <input type="text" name="unit_kerja" id="unit_kerja" class="form-control form-control-premium" placeholder="Contoh: Dinas Komunikasi dan Informatika" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="tingkat_biaya" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tingkat Biaya</label>
                    <select name="tingkat_biaya" id="tingkat_biaya" class="form-select form-control-premium" required>
                        <option value="">-- Pilih Tingkat Biaya --</option>
                        <option value="Tingkat A">Tingkat A</option>
                        <option value="Tingkat B">Tingkat B</option>
                        <option value="Tingkat C">Tingkat C</option>
                        <option value="Tingkat D">Tingkat D</option>
                    </select>
                </div>
            </div>
            
            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-premium-primary px-4 py-2">
                    <i data-lucide="save" class="me-2"></i> Simpan Pegawai
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
