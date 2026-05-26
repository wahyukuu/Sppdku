<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card" style="max-width: 800px; margin: 0 auto;">
    <div class="mb-4">
        <a href="<?= base_url('pejabat') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius: 8px;">
            <i data-lucide="arrow-left" class="me-1"></i> Kembali
        </a>
        <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Edit Pejabat Penandatangan</h5>
        <p class="text-muted m-0" style="font-size: 13px;">Perbarui data pejabat penandatangan di bawah ini.</p>
    </div>

    <form action="<?= base_url('pejabat/update/' . $pejabat['id']) ?>" method="POST">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="id_pegawai" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Pilih Pegawai</label>
                    <select name="id_pegawai" id="id_pegawai" class="form-select form-control-premium" required>
                        <?php foreach ($pegawai as $peg) : ?>
                            <option value="<?= $peg['id_pegawai'] ?>" <?= ($pejabat['id_pegawai'] == $peg['id_pegawai']) ? 'selected' : '' ?>>
                                <?= esc($peg['nama']) ?> (NIP: <?= esc($peg['nip']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="golongan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Golongan Ruang</label>
                    <input type="text" name="golongan" id="golongan" class="form-control form-control-premium" value="<?= esc($pejabat['golongan']) ?>" required autocomplete="off">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="jabatan" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Jabatan TTD (yang dicetak di Surat)</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control form-control-premium" value="<?= esc($pejabat['jabatan']) ?>" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="nomor_nd" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nomor Nota Dinas (Opsional - untuk Plh/Plt)</label>
                    <input type="text" name="nomor_nd" id="nomor_nd" class="form-control form-control-premium" value="<?= esc($pejabat['nomor_nd']) ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="tanggal_nd" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tanggal Nota Dinas (Opsional)</label>
                    <input type="date" name="tanggal_nd" id="tanggal_nd" class="form-control form-control-premium" value="<?= $pejabat['tanggal_nd'] ?>">
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="mb-3">
                    <label class="form-label d-block" style="font-weight:600; font-size:13px; color:#475569;">Status Penandatangan (TTD)</label>
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="status" id="status_kepala" value="Kepala" <?= ($pejabat['status'] === 'Kepala') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status_kepala">Kepala (Definitif)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_pa" value="Pengguna Anggaran" <?= ($pejabat['status'] === 'Pengguna Anggaran') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status_pa">Pengguna Anggaran</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_bp" value="Bendahara Pengeluaran" <?= ($pejabat['status'] === 'Bendahara Pengeluaran') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status_bp">Bendahara Pengeluaran</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_pb" value="Pengurus Barang" <?= ($pejabat['status'] === 'Pengurus Barang') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status_pb">Pengurus Barang</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status_pptk" value="PPTK" <?= ($pejabat['status'] === 'PPTK') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status_pptk">PPTK</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="Plt." <?= ($pejabat['status'] === 'Plt.') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status1">Plt. (Pelaksana Tugas)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="Plh." <?= ($pejabat['status'] === 'Plh.') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status2">Plh. (Pelaksana Harian)</label>
                    </div>
                </div>
            </div>
            
            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-premium-primary px-4 py-2">
                    <i data-lucide="save" class="me-2"></i> Perbarui Pejabat
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
