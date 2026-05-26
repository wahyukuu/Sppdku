<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Bookman Old Style', Georgia, serif;
            color: #000000;
        }

        .paper {
            background-color: #ffffff;
            width: 215mm;
            min-height: 330mm;
            padding: 15mm;
            padding-top: 6mm !important; /* Batas atas kop 0.6 cm sesuai request */
            margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative;
            box-sizing: border-box;
        }

        /* Kop Surat Resmi Kabupaten Aceh Tamiang */
        .kop-surat {
            border-bottom: 4px double #000000;
            padding-bottom: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .kop-logo {
            position: absolute;
            left: 0;
            top: 2px;
        }

        .kop-logo img {
            width: 75px;
            height: auto;
        }

        .kop-text-container {
            width: 100%;
            padding-left: 85px;
            padding-right: 15px;
            text-align: center;
        }

        .kop-text-1 {
            font-size: 14px;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
            color: #000000;
        }

        .kop-text-2 {
            font-size: 15.5px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
            color: #000000;
        }

        .kop-text-3 {
            font-size: 10.5px;
            font-weight: normal;
            margin-top: 4px;
            line-height: 1.3;
            color: #000000;
        }

        /* Judul Kwitansi */
        .judul-kuitansi {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 2px;
            text-align: center;
        }

        .nomor-kuitansi {
            font-size: 13px;
            margin-bottom: 25px;
            text-align: center;
        }

        /* Detail Kwitansi */
        .kuitansi-row {
            margin-bottom: 12px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
        }

        .kuitansi-label {
            width: 170px;
            min-width: 170px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .kuitansi-separator {
            width: 20px;
            min-width: 20px;
            flex-shrink: 0;
            text-align: center;
        }

        .kuitansi-value {
            flex-grow: 1;
        }

        .terbilang-text {
            font-weight: bold;
            font-style: italic;
            font-size: 14.5px;
            word-spacing: 4px;
            text-transform: capitalize;
            display: inline-block;
            margin: 5px 0;
        }

        /* Tabel Rincian Biaya */
        .table-rincian {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            margin-top: 25px;
            margin-bottom: 30px;
        }

        .table-rincian th {
            background-color: #f8fafc;
            border: 1px solid #000000;
            padding: 10px;
            font-weight: bold;
            text-align: center;
        }

        .table-rincian td {
            border: 1px solid #000000;
            padding: 8px 10px;
        }

        .table-rincian td.nominal-col {
            text-align: right;
            width: 180px;
            font-weight: bold;
        }

        /* Tanda Tangan Section */
        .signs-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 13.5px;
        }

        .sign-box {
            width: 220px;
            text-align: center;
        }

        /* Action Toolbar */
        .print-toolbar {
            width: 215mm;
            margin: 20px auto 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        /* Print Media Queries */
        @media print {
            @page {
                size: 215mm 330mm;
                margin: 0;
            }
            body {
                background-color: #ffffff;
                margin: 0;
            }
            .paper {
                box-shadow: none;
                margin: 0;
                padding: 15mm !important;
                padding-top: 6mm !important; /* Batas atas tetap 0.6 cm */
                width: 215mm;
                min-height: 330mm;
                box-sizing: border-box;
            }
            .print-toolbar {
                display: none !important;
            }
            #toolbarContainer {
                display: none !important;
            }
            .terbilang-text {
                /* ensure no box appears in print either */
            }
        }
    </style>
</head>
<body>

    <!-- Toolbar Cetak -->
    <div class="print-toolbar d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0" style="font-weight: 700; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Kuitansi Biaya Siap Cetak</h6>
            <small class="text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Gunakan tombol cetak atau simpan ke PDF di sebelah kanan.</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <i data-lucide="printer" class="me-1"></i> Cetak Kuitansi
            </button>
            <button onclick="window.close()" class="btn btn-outline-secondary" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Tutup Halaman
            </button>
        </div>
    </div>

    <!-- Halaman Kertas Kwitansi -->
    <div class="paper">
        <!-- Kop Surat Resmi Kabupaten Aceh Tamiang -->
        <div class="kop-surat">
            <div class="kop-logo">
                <img src="<?= base_url('assets/img/logo_aceh_tamiang.png') ?>" alt="Logo Aceh Tamiang">
            </div>
            <div class="kop-text-container">
                <div class="kop-text-1">Pemerintah Kabupaten Aceh Tamiang</div>
                <div class="kop-text-2">Dinas Pemberdayaan Masyarakat dan Kampung,</div>
                <div class="kop-text-2">Pemberdayaan Perempuan dan Keluarga Berencana</div>
                <div class="kop-text-3">
                    Jl. Ir. H. Juanda, Komplek Perkantoran Pemerintah Kabupaten Aceh Tamiang<br>
                    Kecamatan Karang Baru Kabupaten Aceh Tamiang Kode Pos 24476
                </div>
            </div>
        </div>

        <!-- Judul Kuitansi -->
        <div class="judul-kuitansi">KUITANSI PEMBAYARAN</div>
        <div class="nomor-kuitansi">Nomor Kuitansi: KW-<?= esc($sppd['id']) ?>/<?= esc($sppd['nomor_surat']) ?></div>

        <!-- Isi Form Kuitansi -->
        <div class="kuitansi-row">
            <div class="kuitansi-label">Sudah Terima Dari</div>
            <div class="kuitansi-separator">:</div>
            <div class="kuitansi-value"><?= isset($bendahara) && $bendahara ? esc($bendahara['jabatan_pejabat']) : 'Bendahara Pengeluaran' ?></div>
        </div>

        <div class="kuitansi-row">
            <div class="kuitansi-label">Uang Sejumlah</div>
            <div class="kuitansi-separator">:</div>
            <div class="kuitansi-value">
                <div class="terbilang-text">
                    "<?= esc($terbilang) ?>"
                </div>
            </div>
        </div>

        <div class="kuitansi-row">
            <div class="kuitansi-label">Untuk Pembayaran</div>
            <div class="kuitansi-separator">:</div>
            <div class="kuitansi-value">
                Biaya Perjalanan Dinas dalam rangka pelaksanaan tugas <b>"<?= esc($sppd['maksud_dinas']) ?>"</b><br>
                berdasarkan Surat Tugas Nomor: <u><?= esc($sppd['nomor_surat']) ?></u> 
                mulai tanggal <?= date('d-m-Y', strtotime($sppd['tanggal_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($sppd['tanggal_selesai'])) ?>.
            </div>
        </div>

        <!-- Tabel Rincian Keuangan Perjalanan Dinas -->
        <table class="table-rincian">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Rincian Pengeluaran</th>
                    <th style="width: 140px;">Biaya</th>
                    <th style="width: 90px;">Satuan</th>
                    <th style="width: 150px;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                
                <?php if ($sppd['jenis'] === 'DL'): ?>
                    <?php if (isset($biaya['transport']) && $biaya['transport'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td>Biaya Transportasi (PP)</td>
                        <td class="text-end">Rp <?= number_format($biaya['transport'], 0, ',', '.') ?></td>
                        <td class="text-center">1 Kali</td>
                        <td class="nominal-col">Rp <?= number_format($biaya['transport'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if (isset($biaya['penginapan']) && $biaya['penginapan'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td>Uang Penginapan / Hotel <?= isset($hotel_option) && $hotel_option === '30' ? '30% (Tanpa Bill)' : '(Reimburse Penuh)' ?></td>
                        <td class="text-end">Rp <?= number_format($tarif_penginapan ?? $biaya['penginapan'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $malam ?> Malam</td>
                        <td class="nominal-col">Rp <?= number_format($total_penginapan, 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if (isset($biaya['harian']) && $biaya['harian'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td>Uang Harian</td>
                        <td class="text-end">Rp <?= number_format($biaya['harian'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $durasi ?> Hari</td>
                        <td class="nominal-col">Rp <?= number_format($total_harian, 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if (isset($biaya['representative']) && $biaya['representative'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td>Uang Representatif</td>
                        <td class="text-end">Rp <?= number_format($biaya['representative'], 0, ',', '.') ?></td>
                        <td class="text-center">1 Kali</td>
                        <td class="nominal-col">Rp <?= number_format($biaya['representative'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                <?php elseif ($sppd['jenis'] === 'DD'): ?>
                    <?php if (isset($biaya['harian']) && $biaya['harian'] > 0): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td>Uang Harian</td>
                        <td class="text-end">Rp <?= number_format($biaya['harian'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $durasi ?> Hari</td>
                        <td class="nominal-col">Rp <?= number_format($total_harian, 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>

                <tr style="background-color: #f8fafc; border-top: 2px solid #000000;">
                    <td colspan="4" class="text-end" style="font-weight: bold; font-size: 14px;">TOTAL BIAYA :</td>
                    <td class="nominal-col" style="font-size: 14.5px;">Rp <?= number_format($total_biaya, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Penandatangan 3 Pihak Standar Kwitansi Keuangan Negara -->
        <div class="signs-container">
            <!-- 1. Bendahara Pengeluaran -->
            <div class="sign-box" style="width: 32%; display: flex; flex-direction: column; justify-content: space-between; min-height: 160px;">
                <div>
                    <div>Setuju dibayar,</div>
                    <div><?= isset($bendahara) && $bendahara ? esc($bendahara['jabatan_pejabat']) : 'Bendahara Pengeluaran' ?></div>
                </div>
                <div>
                    <div style="font-weight: bold; text-decoration: underline;"><?= isset($bendahara) && $bendahara ? esc($bendahara['nama']) : '___________________' ?></div>
                    <div>NIP. <?= isset($bendahara) && $bendahara ? esc($bendahara['nip']) : '___________________' ?></div>
                </div>
            </div>

            <!-- 2. Pejabat Berwenang / KPA -->
            <div class="sign-box" style="width: 32%; display: flex; flex-direction: column; justify-content: space-between; min-height: 160px;">
                <div>
                    <div>Mengetahui / Menyetujui,</div>
                    <div style="font-weight: normal;"><?= ($pejabat['status']) ? $pejabat['status'] . ' ' : '' ?><?= esc($pejabat['jabatan_pejabat']) ?></div>
                </div>
                <div>
                    <div style="font-weight: bold; text-decoration: underline;"><?= esc($pejabat['nama']) ?></div>
                    <div>NIP. <?= esc($pejabat['nip']) ?></div>
                </div>
            </div>

            <!-- 3. Penerima Uang (Pegawai) -->
            <div class="sign-box" style="width: 32%; display: flex; flex-direction: column; justify-content: space-between; min-height: 160px;">
                <div>
                    <div>Diterima oleh,</div>
                    <div><?= esc($sppd['jabatan']) ?></div>
                </div>
                <div>
                    <div style="font-weight: bold; text-decoration: underline;"><?= esc($sppd['nama_pegawai']) ?></div>
                    <div>NIP. <?= esc($sppd['nip']) ?></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
