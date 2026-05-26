<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SPPDKU' ?></title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lucide Icons (JS loaded at bottom) -->
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom Premium CSS Styling -->
    <style>
        :root {
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            --bg-primary: #f8fafc;
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-color: #94a3b8;
            --sidebar-hover-bg: #334155;
            --sidebar-active-bg: linear-gradient(135deg, #6366f1, #4f46e5);
            --sidebar-active-color: #ffffff;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --primary-gradient: linear-gradient(135deg, #4f46e5, #6366f1);
            --danger-gradient: linear-gradient(135deg, #ef4444, #f87171);
            --success-gradient: linear-gradient(135deg, #10b981, #34d399);
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-primary);
            color: #334155;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            font-weight: 600;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #334155;
        }

        .sidebar-brand i {
            font-size: 24px;
            background: linear-gradient(135deg, #818cf8, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-brand span {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 24px 16px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 12px;
            margin-top: 12px;
            padding-left: 12px;
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--sidebar-color);
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }

        .nav-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover-bg);
            color: #ffffff;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #334155;
            background-color: #111827;
        }

        /* Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .top-navbar {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            color: #334155;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #a5b4fc, #6366f1);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-family: var(--font-display);
        }

        .page-content {
            padding: 32px;
            flex-grow: 1;
        }

        /* Card Styling */
        .premium-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08);
        }

        .table-responsive {
            border-radius: 12px;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
        }

        .premium-table {
            margin-bottom: 0;
        }

        .premium-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .premium-table td {
            padding: 16px 20px;
            vertical-align: middle;
            color: #334155;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .premium-table tr:last-child td {
            border-bottom: none;
        }

        /* Premium Buttons */
        .btn-premium-primary {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .btn-premium-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
            color: #ffffff;
        }

        .btn-premium-danger {
            background: var(--danger-gradient);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }

        .btn-premium-danger:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(239, 68, 68, 0.35);
            color: #ffffff;
        }

        /* Form Controls */
        .form-control-premium {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control-premium:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        /* Footer styling */
        .footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 20px 32px;
            font-size: 13px;
            color: #64748b;
            text-align: center;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <!-- Sidebar Layout -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i data-lucide="plane-takeoff"></i>
            <span>SPPDKU</span>
        </div>
        
        <div class="sidebar-menu">
            <a href="<?=base_url('dashboard')?>" class="nav-link <?= ($activeMenu === 'dashboard') ? 'active' : '' ?>">
                <i data-lucide="pie-chart"></i>
                <span>Dashboard</span>
            </a>
            
            <?php if (session()->get('role') === 'admin') : ?>
                <div class="sidebar-menu-title">Data Master</div>
                
                <a href="<?=base_url('pegawai')?>" class="nav-link <?= ($activeMenu === 'pegawai') ? 'active' : '' ?>">
                    <i data-lucide="user"></i>
                    <span>Data Pegawai</span>
                </a>
                
                <a href="<?=base_url('pejabat')?>" class="nav-link <?= ($activeMenu === 'pejabat') ? 'active' : '' ?>">
                    <i data-lucide="briefcase"></i>
                    <span>Data Pejabat</span>
                </a>
                
                <a href="<?=base_url('biaya')?>" class="nav-link <?= ($activeMenu === 'biaya') ? 'active' : '' ?>">
                    <i data-lucide="wallet"></i>
                    <span>Biaya Perjalanan</span>
                </a>
            <?php endif; ?>
            
            <div class="sidebar-menu-title">Transaksi Dinas</div>
            
            <a href="<?=base_url('surat-tugas')?>" class="nav-link <?= ($activeMenu === 'surat-tugas') ? 'active' : '' ?>">
                <i data-lucide="circle"></i>
                <span>Surat Tugas</span>
            </a>
            
            <a href="<?=base_url('sppd')?>" class="nav-link <?= ($activeMenu === 'sppd') ? 'active' : '' ?>">
                <i data-lucide="file-spreadsheet"></i>
                <span>Dokumen SPPD</span>
            </a>

            <?php if (session()->get('role') === 'admin') : ?>
                <div class="sidebar-menu-title">Pengaturan</div>
                
                <a href="<?=base_url('user')?>" class="nav-link <?= ($activeMenu === 'user') ? 'active' : '' ?>">
                    <i data-lucide="user"></i>
                    <span>Manajemen User</span>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="sidebar-footer">
            <a href="<?=base_url('logout')?>" class="nav-link text-danger border-0 m-0 p-2">
                <i data-lucide="log-out"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="m-0 font-display text-slate-800" style="font-weight:700;">
                <?php
                    if ($activeMenu === 'dashboard') echo 'Dashboard Overview';
                    elseif ($activeMenu === 'pegawai') echo 'Manajemen Pegawai';
                    elseif ($activeMenu === 'pejabat') echo 'Pejabat Penandatangan';
                    elseif ($activeMenu === 'biaya') echo 'Tarif Perjalanan Dinas';
                    elseif ($activeMenu === 'surat-tugas') echo 'Daftar Surat Tugas';
                    elseif ($activeMenu === 'sppd') echo 'Penerbitan SPPD';
                    elseif ($activeMenu === 'user') echo 'Manajemen User';
                ?>
            </h4>
            
            <div class="d-flex align-items-center gap-3">
                <div class="navbar-user">
                    <div class="avatar-circle">
                        <?= substr(session()->get('nama') ?? 'A', 0, 1) ?>
                    </div>
                    <div class="d-none d-md-block text-start">
                        <div style="font-size:14px; font-weight:600;"><?= session()->get('nama') ?? 'Administrator' ?></div>
                        <div style="font-size:11px; color:#64748b; text-transform:uppercase; font-weight:700;"><?= session()->get('role') ?? 'admin' ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inner page content -->
        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <span>&copy; 2026 SPPDKU - Sistem Perjalanan Dinas Premium. All Rights Reserved.</span>
        </footer>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Trigger SweetAlert for flash data notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('success')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?= session()->getFlashdata("success") ?>',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'border-radius-16'
                    }
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= session()->getFlashdata("error") ?>',
                    confirmButtonColor: '#6366f1',
                    customClass: {
                        popup: 'border-radius-16'
                    }
                });
            <?php endif; ?>
        });
    </script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
