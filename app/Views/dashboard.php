<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <!-- Stat 1: Total Pegawai -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="premium-card d-flex align-items-center justify-content-between relative overflow-hidden" style="border-left: 4px solid #6366f1;">
            <div>
                <h6 class="text-uppercase mb-1" style="font-size:12px; color:#64748b; font-weight:600; letter-spacing:0.5px;">Total Pegawai</h6>
                <h2 class="mb-0 font-display" style="font-weight:800; color:#1e293b;"><?= $total_pegawai ?></h2>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 12px;">
                <i data-lucide="users"></i>
            </div>
        </div>
    </div>

    <!-- Stat 2: Total Pejabat -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="premium-card d-flex align-items-center justify-content-between relative overflow-hidden" style="border-left: 4px solid #f59e0b;">
            <div>
                <h6 class="text-uppercase mb-1" style="font-size:12px; color:#64748b; font-weight:600; letter-spacing:0.5px;">Pejabat TTD</h6>
                <h2 class="mb-0 font-display" style="font-weight:800; color:#1e293b;"><?= $total_pejabat ?></h2>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 12px;">
                <i data-lucide="briefcase"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3: Total Surat Tugas -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="premium-card d-flex align-items-center justify-content-between relative overflow-hidden" style="border-left: 4px solid #ec4899;">
            <div>
                <h6 class="text-uppercase mb-1" style="font-size:12px; color:#64748b; font-weight:600; letter-spacing:0.5px;">Surat Tugas</h6>
                <h2 class="mb-0 font-display" style="font-weight:800; color:#1e293b;"><?= $total_surat_tugas ?></h2>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(236, 72, 153, 0.1); color: #ec4899; border-radius: 12px;">
                <i data-lucide="file-pen"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4: Total SPPD -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="premium-card d-flex align-items-center justify-content-between relative overflow-hidden" style="border-left: 4px solid #10b981;">
            <div>
                <h6 class="text-uppercase mb-1" style="font-size:12px; color:#64748b; font-weight:600; letter-spacing:0.5px;">Dokumen SPPD</h6>
                <h2 class="mb-0 font-display" style="font-weight:800; color:#1e293b;"><?= $total_sppd ?></h2>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 12px;">
                <i data-lucide="receipt"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Shortcuts -->
<div class="row g-4 mt-2">
    <div class="col-12 col-xl-4">
        <div class="premium-card h-100">
            <h5 class="mb-3 font-display" style="font-weight: 700; color:#1e293b;"><i data-lucide="circle" class="me-2 text-indigo-500"></i>Aksi Cepat</h5>
            <p class="text-muted" style="font-size:13px; line-height:1.6;">Gunakan pintasan cepat berikut untuk langsung membuat dokumen perjalanan dinas baru di aplikasi.</p>
            <div class="d-flex flex-column gap-2 mt-4">
                <a href="<?= base_url('surat-tugas/create') ?>" class="btn btn-premium-primary w-100 text-center py-3">
                    <i data-lucide="plus-circle" class="me-2"></i> Buat Surat Tugas Baru
                </a>
                <a href="<?= base_url('pegawai/create') ?>" class="btn btn-outline-secondary w-100 py-3 rounded-3" style="font-size:14px; font-weight:600; border-radius:10px;">
                    <i data-lucide="user-plus" class="me-2"></i> Tambah Pegawai Baru
                </a>
                <a href="<?= base_url('biaya/create') ?>" class="btn btn-outline-secondary w-100 py-3 rounded-3" style="font-size:14px; font-weight:600; border-radius:10px;">
                    <i data-lucide="plus" class="me-2"></i> Konfigurasi Tarif Biaya
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activities / Surat Tugas -->
    <div class="col-12 col-xl-8">
        <div class="premium-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-display" style="font-weight: 700; color:#1e293b;"><i data-lucide="circle" class="me-2 text-indigo-500"></i>Penerbitan Surat Tugas Terkini</h5>
                <a href="<?= base_url('surat-tugas') ?>" class="btn btn-sm btn-link text-decoration-none" style="font-weight:600; font-size:13px; color:#4f46e5;">Lihat Semua <i data-lucide="circle" class="ms-1"></i></a>
            </div>
            
            <div class="table-responsive">
                <table class="table premium-table align-middle">
                    <thead>
                        <tr>
                            <th>No. Surat</th>
                            <th>Tujuan Dinas</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_surat_tugas)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada surat tugas yang diterbitkan.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($recent_surat_tugas as $st) : ?>
                                <tr>
                                    <td style="font-weight: 600; color: #1e293b;"><?= $st['nomor_surat'] ?></td>
                                    <td><?= esc($st['tujuan']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($st['tanggal_mulai'])) ?></td>
                                    <td><?= date('d-m-Y', strtotime($st['tanggal_selesai'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= ($st['jenis'] === 'DL') ? 'primary' : 'warning' ?> rounded-pill" style="font-size:11px; padding: 6px 12px; font-weight: 600;">
                                            <?= ($st['jenis'] === 'DL') ? 'Dinas Luar' : 'Dinas Dalam' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
