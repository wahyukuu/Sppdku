<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Daftar Tarif Biaya Perjalanan Dinas</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Konfigurasi besaran uang harian, transport, dan penginapan berdasarkan tingkat perjalanan.</p>
        </div>
        <a href="<?= base_url('biaya/create') ?>" class="btn btn-premium-primary">
            <i data-lucide="plus-circle" class="me-2"></i> Tambah Tarif
        </a>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Tingkat Biaya</th>
                    <th>Tujuan</th>
                    <th>Tipe (DL/DD)</th>
                    <th>Transportasi (Maksimal)</th>
                    <th>Penginapan / Hotel (Per Malam)</th>
                    <th>Uang Harian (Per Hari)</th>
                    <th>Uang Representative</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($biaya)) : ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data tarif biaya. Silakan tambah data biaya.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($biaya as $b) : ?>
                        <tr>
                            <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                            <td>
                                <span class="badge bg-indigo-100 text-indigo-700 px-3 py-2 rounded-pill" style="font-weight:600; font-size:12px; background-color: rgba(99, 102, 241, 0.1); color:#4f46e5;">
                                    <?= esc($b['tingkat']) ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;"><?= esc($b['tujuan']) ?: '-' ?></td>
                            <td>
                                <span class="badge bg-<?= ($b['jenis'] === 'DL') ? 'primary' : 'warning' ?> px-3 py-2 rounded-pill" style="font-weight:600; font-size:11px;">
                                    <?= ($b['jenis'] === 'DL') ? 'Luar Daerah (DL)' : 'Dalam Daerah (DD)' ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">Rp <?= number_format($b['transport'], 0, ',', '.') ?></td>
                            <td style="font-weight: 600; color: #1e293b;">Rp <?= number_format($b['penginapan'], 0, ',', '.') ?></td>
                            <td style="font-weight: 600; color: #10b981;">Rp <?= number_format($b['harian'], 0, ',', '.') ?></td>
                            <td style="font-weight: 600; color: #f59e0b;">Rp <?= number_format($b['representative'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="<?= base_url('biaya/edit/' . $b['id']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" title="Edit Tarif">
                                        <i data-lucide="edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $b['id'] ?>)" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus Tarif">
                                        <i data-lucide="trash-2"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data tarif biaya ini akan terhapus dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'border-radius-16'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('biaya/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
