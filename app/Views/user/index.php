<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Daftar Pengguna Sistem</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Kelola akun pengguna yang berhak mengakses dan mengoperasikan aplikasi SPPDKU.</p>
        </div>
        <a href="<?= base_url('user/create') ?>" class="btn btn-premium-primary" style="border-radius: 10px;">
            <i data-lucide="user-plus" class="me-2"></i> Tambah User Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Hak Akses / Role</th>
                    <th>Tanggal Terdaftar</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($users as $us) : ?>
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle" style="width: 38px; height: 38px; background: linear-gradient(135deg, #6366f1, #4f46e5); font-weight:700;">
                                    <?= strtoupper(substr($us['nama'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;"><?= esc($us['nama']) ?></div>
                                    <div style="font-size: 11px; color: #64748b;">ID: #<?= $us['id_user'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight: 600; color: #334155;"><?= esc($us['username']) ?></td>
                        <td>
                            <?php if ($us['role'] === 'admin') : ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 600;">
                                    <i data-lucide="shield" class="me-1"></i> Administrator
                                </span>
                            <?php else : ?>
                                <span class="badge bg-primary px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 600;">
                                    <i data-lucide="user" class="me-1"></i> User Biasa
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size: 13px; color: #64748b;">
                            <?= date('d-m-Y H:i', strtotime($us['created_at'])) ?>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="<?= base_url('user/edit/' . $us['id_user']) ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" title="Edit User">
                                    <i data-lucide="edit"></i>
                                </a>
                                <button onclick="confirmDelete(<?= $us['id_user'] ?>)" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus User">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
            text: "Pengguna ini tidak akan bisa mengakses sistem lagi!",
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
                window.location.href = "<?= base_url('user/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
