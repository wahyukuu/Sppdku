<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Daftar Dokumen SPPD</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Kelola penerbitan, cetak dokumen resmi SPPD, dan kuitansi pertanggungjawaban biaya.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nomor Surat Tugas</th>
                    <th>Pegawai Pelaksana</th>
                    <th>NIP</th>
                    <th>Durasi Tugas</th>
                    <th>Tipe Perjalanan</th>
                    <th class="text-center">Aksi Dokumen</th>
                    <th style="width: 100px;" class="text-center">Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sppd)) : ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada SPPD yang diterbitkan. Buat Surat Tugas terlebih dahulu untuk menerbitkan SPPD.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($sppd as $sp) : ?>
                        <tr>
                            <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;"><?= esc($sp['nomor_surat']) ?></div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 32px; height: 32px; font-size:12px; background: linear-gradient(135deg, #34d399, #10b981);">
                                        <?= substr($sp['nama_pegawai'], 0, 1) ?>
                                    </div>
                                    <div style="font-weight: 600; color: #1e293b;"><?= esc($sp['nama_pegawai']) ?></div>
                                </div>
                            </td>
                            <td><?= esc($sp['nip']) ?></td>
                            <td>
                                <div style="font-size:13px; font-weight:600;">
                                    <i data-lucide="calendar-check" class="text-success me-1"></i>
                                    <?= date('d-m-Y', strtotime($sp['tanggal_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($sp['tanggal_selesai'])) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($sp['jenis'] === 'DL') ? 'primary' : 'warning' ?> px-3 py-2 rounded-pill" style="font-size:11px; font-weight:600;">
                                    <?= ($sp['jenis'] === 'DL') ? 'Luar Daerah' : 'Dalam Daerah' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="<?= base_url('sppd/print/' . $sp['id']) ?>" target="_blank" class="btn btn-sm btn-premium-primary" style="padding: 8px 16px; font-size:12.5px; border-radius:8px;">
                                        <i data-lucide="printer" class="me-1"></i> Cetak SPPD
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 16px; font-size:12.5px; border-radius:8px; font-weight:600;">
                                            <i data-lucide="receipt" class="me-1"></i> Kuitansi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('sppd/kwitansi/' . $sp['id'] . '?hotel=full') ?>" target="_blank">Reimburse Penuh (Ada Bill Hotel)</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url('sppd/kwitansi/' . $sp['id'] . '?hotel=30') ?>" target="_blank">30% (Tanpa Bill Hotel)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button onclick="confirmDelete(<?= $sp['id'] ?>)" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus SPPD">
                                    <i data-lucide="trash-2"></i>
                                </button>
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
            text: "Menghapus SPPD akan menghilangkan dokumen pertanggungjawaban ini!",
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
                window.location.href = "<?= base_url('sppd/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
