<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card" style="max-width: 800px; margin: 0 auto;">
    <div class="mb-4">
        <a href="<?= base_url('biaya') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius: 8px;">
            <i data-lucide="arrow-left" class="me-1"></i> Kembali
        </a>
        <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Tambah Tarif Perjalanan Dinas</h5>
        <p class="text-muted m-0" style="font-size: 13px;">Definisikan data tingkat tarif biaya perjalanan dinas baru.</p>
    </div>

    <form action="<?= base_url('biaya/store') ?>" method="POST">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="tingkat" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nama Tingkat Biaya</label>
                    <input type="text" name="tingkat" id="tingkat" class="form-control form-control-premium" placeholder="Contoh: Tingkat A atau Tingkat B" required autocomplete="off">
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="jenis" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tipe Perjalanan Dinas</label>
                    <select name="jenis" id="jenis" class="form-select form-control-premium" required>
                        <option value="DL">Luar Daerah (DL)</option>
                        <option value="DD">Dalam Daerah (DD)</option>
                    </select>
                </div>
            </div>
            
            <div class="col-12 col-md-12">
                <div class="mb-3">
                    <label for="tujuan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tujuan (opsional, misal: Banda Aceh)</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control form-control-premium" placeholder="Kosongkan jika berlaku umum" autocomplete="off">
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="transport" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tarif Transportasi (IDR)</label>
                    <input type="number" name="transport" id="transport" class="form-control form-control-premium" placeholder="Contoh: 1500000" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="penginapan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tarif Penginapan / Malam (IDR)</label>
                    <input type="number" name="penginapan" id="penginapan" class="form-control form-control-premium" placeholder="Contoh: 750000" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="harian" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tarif Uang Harian / Hari (IDR)</label>
                    <input type="number" name="harian" id="harian" class="form-control form-control-premium" placeholder="Contoh: 400000" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="representative" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tarif Uang Representative (IDR)</label>
                    <input type="number" name="representative" id="representative" class="form-control form-control-premium" placeholder="Contoh: 200000" required autocomplete="off">
                </div>
            </div>
            
            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-premium-primary px-4 py-2">
                    <i data-lucide="save" class="me-2"></i> Simpan Tarif
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
