<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Daftar Pegawai</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Kelola profil data pegawai negeri sipil aktif.</p>
        </div>
        <a href="<?= base_url('pegawai/create') ?>" class="btn btn-premium-primary">
            <i data-lucide="plus-circle" class="me-2"></i> Tambah Pegawai
        </a>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>Golongan</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Tarif Biaya</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pegawai)) : ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data pegawai. Silakan tambah data pegawai.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($pegawai as $p) : ?>
                        <tr>
                            <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= esc($p['nip']) ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 32px; height: 32px; font-size:12px; background: linear-gradient(135deg, #a5b4fc, #818cf8);">
                                        <?= substr($p['nama'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;"><?= esc($p['nama']) ?></div>
                                        <small class="text-muted" style="font-size:11px;"><?= esc($p['pangkat']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($p['golongan']) ?></td>
                            <td><?= esc($p['jabatan']) ?></td>
                            <td><?= esc($p['unit_kerja']) ?></td>
                            <td>
                                <span class="badge bg-indigo-100 text-indigo-700 px-3 py-2 rounded-pill" style="font-weight:600; font-size:11px; background-color: rgba(99, 102, 241, 0.1); color:#4f46e5;">
                                    <?= esc($p['tingkat_biaya']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="<?= base_url('pegawai/edit/' . $p['id_pegawai']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" title="Edit Pegawai">
                                        <i data-lucide="edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $p['id_pegawai'] ?>)" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus Pegawai">
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
            text: "Data pegawai akan terhapus secara permanen dari sistem!",
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
                window.location.href = "<?= base_url('pegawai/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
