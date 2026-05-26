<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card" style="max-width: 900px; margin: 0 auto;">
    <div class="mb-4">
        <a href="<?= base_url('surat-tugas') ?>" class="btn btn-sm btn-outline-secondary mb-3" style="border-radius: 8px;">
            <i data-lucide="arrow-left" class="me-1"></i> Kembali
        </a>
        <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Edit Surat Tugas</h5>
        <p class="text-muted m-0" style="font-size: 13px;">Perbarui data surat tugas dan sesuaikan personel yang ditugaskan.</p>
    </div>

    <form action="<?= base_url('surat-tugas/update/' . $suratTugas['id']) ?>" method="POST">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="nomor_surat" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Nomor Surat Tugas</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control form-control-premium" value="<?= esc($suratTugas['nomor_surat']) ?>" required autocomplete="off">
                </div>
            </div>
            
            <div class="col-12 col-md-3">
                <div class="mb-3">
                    <label for="jenis" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Jenis Dinas</label>
                    <select name="jenis" id="jenis" class="form-select form-control-premium" required>
                        <option value="DL" <?= ($suratTugas['jenis'] === 'DL') ? 'selected' : '' ?>>Luar Daerah (DL)</option>
                        <option value="DD" <?= ($suratTugas['jenis'] === 'DD') ? 'selected' : '' ?>>Dalam Daerah (DD)</option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="mb-3">
                    <label for="tanggal_surat" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control form-control-premium" value="<?= $suratTugas['tanggal_surat'] ?>" required>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="dasar_surat" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Dasar Penugasan (Surat/Dokumen Rujukan)</label>
                    <textarea name="dasar_surat" id="dasar_surat" class="form-control form-control-premium" rows="3" required><?= esc($suratTugas['dasar_surat']) ?></textarea>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="maksud" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Maksud Perjalanan Dinas (Untuk)</label>
                    <input type="text" name="maksud" id="maksud" class="form-control form-control-premium" value="<?= esc($suratTugas['maksud']) ?>" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label" style="font-weight:600; font-size:13px; color:#475569; display: flex; justify-content: space-between; align-items: center;">
                        <span>Tempat Tujuan Dinas (Di) - Maksimal 5</span>
                        <button type="button" id="btn-add-tujuan" class="btn btn-xs btn-outline-primary" style="font-size: 11px; padding: 2px 8px; border-radius: 4px;"><i data-lucide="plus"></i> Tambah Tujuan</button>
                    </label>
                    <div id="tujuan-container">
                        <?php 
                        $destCount = count($destinations ?? []);
                        if ($destCount > 0): 
                            foreach ($destinations as $index => $dest):
                        ?>
                            <div class="d-flex mb-2 align-items-center">
                                <input type="text" name="tujuan[]" class="form-control form-control-premium" value="<?= esc($dest['tujuan']) ?>" placeholder="<?= $index === 0 ? 'Tujuan 1 (Contoh: Banda Aceh)' : 'Tujuan ' . ($index + 1) . ' (Opsional)' ?>" <?= $index === 0 ? 'required' : '' ?> autocomplete="off">
                                <?php if ($index === 0): ?>
                                    <span style="width: 32px; display: inline-block;"></span>
                                <?php else: ?>
                                    <button type="button" class="btn btn-outline-danger btn-remove-tujuan" style="width: 32px; height: 38px; padding: 0; margin-left: 8px; display: flex; align-items: center; justify-content: center; border-radius: 6px;"><i data-lucide="trash-2"></i></button>
                                <?php endif; ?>
                            </div>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                            <div class="d-flex mb-2 align-items-center">
                                <input type="text" name="tujuan[]" class="form-control form-control-premium" value="<?= esc($suratTugas['tujuan']) ?>" placeholder="Tujuan 1 (Contoh: Banda Aceh)" required autocomplete="off">
                                <span style="width: 32px; display: inline-block;"></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tanggal Pelaksanaan Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control form-control-premium" value="<?= $suratTugas['tanggal_mulai'] ?>" required>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Tanggal Pelaksanaan Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control form-control-premium" value="<?= $suratTugas['tanggal_selesai'] ?>" required>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="id_pejabat_ttd" class="form-label" style="font-weight:600; font-size:13px; color:#475569;">Pejabat Penandatangan Surat</label>
                    <select name="id_pejabat_ttd" id="id_pejabat_ttd" class="form-select form-control-premium" required>
                        <?php foreach ($pejabat as $pj) : ?>
                            <option value="<?= $pj['id'] ?>" <?= ($suratTugas['id_pejabat_ttd'] == $pj['id']) ? 'selected' : '' ?>>
                                <?= esc($pj['nama_pegawai']) ?> (Status: <?= esc($pj['status']) ?> - <?= esc($pj['jabatan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- CHECKBOX PILIH MULTI-PEGAWAI -->
            <div class="col-12 mt-3">
                <label class="form-label d-block mb-3" style="font-weight:600; font-size:14px; color:#1e293b;">Pilih Pegawai yang Ditugaskan</label>
                <div class="border rounded-3 p-3 bg-light" style="max-height: 250px; overflow-y: auto;">
                    <div class="row g-2">
                        <?php foreach ($pegawai as $peg) : ?>
                            <div class="col-12 col-md-6">
                                <div class="form-check p-3 bg-white border rounded-3 d-flex align-items-center gap-2" style="cursor:pointer; transition: all 0.2s;">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="id_pegawai[]" value="<?= $peg['id_pegawai'] ?>" id="peg_<?= $peg['id_pegawai'] ?>"
                                           <?= in_array($peg['id_pegawai'], $assignedIds) ? 'checked' : '' ?>>
                                    <label class="form-check-label w-100" for="peg_<?= $peg['id_pegawai'] ?>" style="cursor:pointer;">
                                        <div style="font-weight:600; font-size:13.5px; color:#1e293b;"><?= esc($peg['nama']) ?></div>
                                        <div style="font-size:11px; color:#64748b;">NIP: <?= esc($peg['nip']) ?> | <?= esc($peg['tingkat_biaya']) ?></div>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-premium-primary px-4 py-2">
                    <i data-lucide="save" class="me-2"></i> Perbarui Surat Tugas & SPPD
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('tujuan-container');
    const btnAdd = document.getElementById('btn-add-tujuan');
    
    // Bind click handlers to existing remove buttons
    if (container) {
        container.querySelectorAll('.btn-remove-tujuan').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.d-flex').remove();
                reindexPlaceholders();
            });
        });
    }
    
    function reindexPlaceholders() {
        const remainingInputs = container.querySelectorAll('input[name="tujuan[]"]');
        remainingInputs.forEach((input, idx) => {
            if (idx > 0) {
                input.placeholder = `Tujuan ${idx + 1} (Opsional)`;
            }
        });
    }

    if (btnAdd && container) {
        btnAdd.addEventListener('click', function() {
            const inputs = container.querySelectorAll('input[name="tujuan[]"]');
            if (inputs.length >= 5) {
                alert('Maksimal 5 tempat tujuan.');
                return;
            }
            
            const index = inputs.length + 1;
            const div = document.createElement('div');
            div.className = 'd-flex mb-2 align-items-center';
            div.innerHTML = `
                <input type="text" name="tujuan[]" class="form-control form-control-premium" placeholder="Tujuan ${index} (Opsional)" autocomplete="off">
                <button type="button" class="btn btn-outline-danger btn-remove-tujuan" style="width: 32px; height: 38px; padding: 0; margin-left: 8px; display: flex; align-items: center; justify-content: center; border-radius: 6px;"><i data-lucide="trash-2"></i></button>
            `;
            container.appendChild(div);
            
            div.querySelector('.btn-remove-tujuan').addEventListener('click', function() {
                div.remove();
                reindexPlaceholders();
            });
        });
    }
});
</script>

<?= $this->endSection() ?>
