<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Daftar Pejabat Penandatangan</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Kelola pejabat yang berwenang menerbitkan Surat Tugas dan SPPD.</p>
        </div>
        <a href="<?= base_url('pejabat/create') ?>" class="btn btn-premium-primary">
            <i data-lucide="plus-circle" class="me-2"></i> Tambah Pejabat
        </a>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama Pejabat (Pegawai)</th>
                    <th>NIP</th>
                    <th>Jabatan Penandatangan</th>
                    <th>Golongan</th>
                    <th>Status TTD</th>
                    <th>Dasar Nota Dinas (ND)</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pejabat)) : ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data pejabat. Silakan tambah data pejabat.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($pejabat as $pj) : ?>
                        <tr>
                            <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= esc($pj['nama_pegawai']) ?></td>
                            <td><?= esc($pj['nip']) ?></td>
                            <td style="font-weight: 500;"><?= esc($pj['jabatan']) ?></td>
                            <td><?= esc($pj['golongan']) ?></td>
                            <td>
                                <?php
                                $badgeClass = 'info';
                                if ($pj['status'] === 'Plh.') $badgeClass = 'warning';
                                if ($pj['status'] === 'Kepala') $badgeClass = 'primary';
                                if ($pj['status'] === 'Pengguna Anggaran') $badgeClass = 'success';
                                ?>
                                <span class="badge bg-<?= $badgeClass ?> px-3 py-2 rounded-pill" style="font-size:11px; font-weight:600;">
                                    <?= esc($pj['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($pj['nomor_nd'])) : ?>
                                    <div><b>No:</b> <?= esc($pj['nomor_nd']) ?></div>
                                    <small class="text-muted" style="font-size:11px;"><b>Tanggal:</b> <?= (!empty($pj['tanggal_nd']) && $pj['tanggal_nd'] !== '0000-00-00') ? date('d-m-Y', strtotime($pj['tanggal_nd'])) : '-' ?></small>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="<?= base_url('pejabat/edit/' . $pj['id']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" title="Edit Pejabat">
                                        <i data-lucide="edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $pj['id'] ?>)" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus Pejabat">
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
            text: "Data pejabat penandatangan akan terhapus dari sistem!",
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
                window.location.href = "<?= base_url('pejabat/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
