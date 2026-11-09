<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;">Penerbitan Surat Tugas</h5>
            <p class="text-muted m-0" style="font-size: 13px;">Kelola penerbitan surat tugas dan penugasan personel dinas.</p>
        </div>
        <a href="<?= base_url('surat-tugas/create') ?>" class="btn btn-premium-primary">
            <i data-lucide="plus-circle" class="me-2"></i> Terbitkan Surat Tugas
        </a>
    </div>

    <div class="table-responsive">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nomor Surat Tugas</th>
                    <th>Pegawai Ditugaskan</th>
                    <th>Tujuan Dinas</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Jenis</th>
                    <th>Penandatangan</th>
                    <th>Status</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($suratTugas)) : ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada surat tugas diterbitkan. Silakan terbitkan surat tugas baru.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($suratTugas as $st) : ?>
                        <tr>
                            <td class="text-center" style="font-weight: 600; color: #64748b;"><?= $no++ ?></td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;"><?= esc($st['nomor_surat']) ?></div>
                                <small class="text-muted" style="font-size:11px;"><b>Tgl Surat:</b> <?= date('d-m-Y', strtotime($st['tanggal_surat'])) ?></small>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                    <?php if (!empty($st['pegawai'])) : ?>
                                        <?php foreach ($st['pegawai'] as $pegName) : ?>
                                            <span class="badge bg-slate-100 text-slate-700 px-2 py-1 rounded" style="font-size:10px; font-weight:550; border: 1px solid #cbd5e1; background-color:#f1f5f9; color:#334155;">
                                                <i data-lucide="user" class="me-1 text-slate-500"></i><?= esc($pegName) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <span class="text-danger" style="font-size:12px;">Tidak ada pegawai</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td style="font-weight:500; font-size:13.5px;"><?= esc($st['tujuan']) ?></td>
                            <td>
                                <div style="font-size:13px; font-weight: 600;">
                                    <i data-lucide="calendar-check" class="text-indigo-500 me-1"></i>
                                    <?= date('d-m-Y', strtotime($st['tanggal_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($st['tanggal_selesai'])) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($st['jenis'] === 'DL') ? 'primary' : 'warning' ?> px-3 py-2 rounded-pill" style="font-size:11px; font-weight:600;">
                                    <?= ($st['jenis'] === 'DL') ? 'Luar Daerah' : 'Dalam Daerah' ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:550; font-size:13px;"><?= esc($st['nama_pejabat']) ?></div>
                            </td>
                            <td>
                                <?php
                                $s = $st['status'] ?? 'aktif';
                                if ($s === 'aktif') echo '<span class="badge bg-success px-2 py-1 rounded-pill" style="font-size:11px;">Aktif</span>';
                                elseif ($s === 'selesai') echo '<span class="badge bg-primary px-2 py-1 rounded-pill" style="font-size:11px;">Selesai</span>';
                                else echo '<span class="badge bg-secondary px-2 py-1 rounded-pill" style="font-size:11px;">Diarsipkan</span>';
                                ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px; padding: 4px 8px;">
                                            <i data-lucide="settings"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('surat-tugas/print/' . $st['id']) ?>" target="_blank"><i data-lucide="printer" class="me-2" style="width:16px;"></i> Cetak SPT</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url('surat-tugas/edit/' . $st['id']) ?>"><i data-lucide="edit" class="me-2" style="width:16px;"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <?php if (($st['status'] ?? 'aktif') === 'aktif') : ?>
                                                <li><a class="dropdown-item text-primary" href="<?= base_url('surat-tugas/status/' . $st['id'] . '/selesai') ?>"><i data-lucide="check-circle" class="me-2" style="width:16px;"></i> Tandai Selesai</a></li>
                                            <?php endif; ?>
                                            <?php if (($st['status'] ?? 'aktif') === 'selesai') : ?>
                                                <li><a class="dropdown-item text-secondary" href="<?= base_url('surat-tugas/status/' . $st['id'] . '/diarsipkan') ?>"><i data-lucide="archive" class="me-2" style="width:16px;"></i> Arsipkan</a></li>
                                            <?php endif; ?>
                                            <li><button class="dropdown-item text-danger" onclick="confirmDelete(<?= $st['id'] ?>)"><i data-lucide="trash-2" class="me-2" style="width:16px;"></i> Hapus</button></li>
                                        </ul>
                                    </div>
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
            text: "Menghapus surat tugas akan ikut menghapus dokumen SPPD terkait di database!",
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
                window.location.href = "<?= base_url('surat-tugas/delete') ?>/" + id;
            }
        })
    }
</script>
<?= $this->endSection() ?>
