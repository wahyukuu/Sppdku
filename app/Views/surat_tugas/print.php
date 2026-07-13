<?php
$start = new DateTime($suratTugas['tanggal_mulai']);
$end = new DateTime($suratTugas['tanggal_selesai']);
$durasi = 0;
$current = clone $start;

$hitungSabtu = !empty($suratTugas['hitung_sabtu']);
$hitungMinggu = !empty($suratTugas['hitung_minggu']);

while ($current <= $end) {
    $dayOfWeek = $current->format('N'); // 1-5 Mon-Fri, 6 Sat, 7 Sun
    
    if ($dayOfWeek == 6 && !$hitungSabtu) {
        // Jangan dihitung
    } elseif ($dayOfWeek == 7 && !$hitungMinggu) {
        // Jangan dihitung
    } else {
        $durasi++;
    }
    $current->modify('+1 day');
}

function terbilangDurasi($number) {
    $words = [
        1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima',
        6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan', 10 => 'sepuluh',
        11 => 'sebelas', 12 => 'dua belas', 13 => 'tiga belas', 14 => 'empat belas', 15 => 'lima belas'
    ];
    return $words[$number] ?? '';
}

function tanggalIndo($date) {
    if (empty($date)) return '';
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $split = explode('-', date('Y-m-d', strtotime($date)));
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
?>
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
            padding: 15mm 10mm;
            padding-top: 6mm !important; /* Batas atas kop 0.6 cm sesuai request */
            margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative;
            box-sizing: border-box;
        }

        /* Kop Surat Resmi Kabupaten Aceh Tamiang */
        .kop-surat {
            border-bottom: 2.5pt solid #000000;
            padding-bottom: 12px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            font-family: Arial, Helvetica, sans-serif;
            min-height: 125px;
        }

        .kop-logo {
            position: absolute;
            left: 25px;
            top: 2px;
        }

        .kop-logo img {
            width: 110px;
            height: auto;
        }

        .kop-text-container {
            width: 100%;
            padding-left: 145px;
            padding-right: 15px;
            margin-top: 5px;
            text-align: center;
        }

        .kop-text-1 {
            font-size: 16px;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0px;
            line-height: 1.1;
            color: #000000;
        }

        .kop-text-2 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.05;
            color: #000000;
        }

        .kop-text-3 {
            font-size: 13px;
            font-weight: normal;
            margin-top: 4px;
            line-height: 1.15;
            color: #000000;
        }

        /* Judul SPT */
        .judul-spt {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 2px;
            margin-top: 15px;
        }

        .nomor-spt {
            font-size: 14px;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            white-space: pre-wrap;
        }

        /* Konten Isi Dokumen */
        .spt-label-row {
            display: flex;
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.5;
        }

        .spt-label {
            width: 80px;
            flex-shrink: 0;
        }

        .spt-separator {
            width: 20px;
            flex-shrink: 0;
            text-align: center;
        }

        .spt-content {
            flex-grow: 1;
            text-align: justify;
        }

        /* Bagian Tanda Tangan */
        .spt-footer-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
            font-size: 14px;
            line-height: 1.4;
        }

        .spt-footer-box {
            width: 300px;
            text-align: left;
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
                padding: 15mm 10mm !important;
                padding-top: 6mm !important; /* Tetap 0.6 cm di print */
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
        }
    </style>
</head>
<body>

    <!-- Toolbar Cetak -->
    <div class="print-toolbar d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0" style="font-weight: 700; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Surat Perintah Tugas (SPT) Siap Cetak</h6>
            <small class="text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Ukuran Kertas: F4 | Kop: 0.6 cm | Margin T/B: 1.5 cm, L/R: 1 cm</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; border-radius: 8px;">
                <i data-lucide="printer" class="me-1"></i> Cetak Dokumen
            </button>
            <button onclick="window.close()" class="btn btn-outline-secondary" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; border-radius: 8px;">
                Tutup Halaman
            </button>
        </div>
    </div>

    <!-- Halaman Kertas F4 -->
    <div class="paper">
        <!-- Kop Surat Resmi Kabupaten Aceh Tamiang -->
        <div class="kop-surat">
            <div class="kop-logo">
                <?php helper('url'); ?>
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

        <!-- Judul Dokumen SPT -->
        <div class="judul-spt">SURAT TUGAS</div>
        <div class="nomor-spt">NOMOR : <?= str_replace(' ', '&nbsp;', esc($suratTugas['nomor_surat'])) ?></div>

        <!-- Dasar Penugasan -->
        <div class="spt-label-row">
            <div class="spt-label">Dasar</div>
            <div class="spt-separator">:</div>
            <div class="spt-content">
                <?= esc($suratTugas['dasar_surat']) ?>
            </div>
        </div>

        <div class="text-center my-4" style="font-weight: normal; font-size: 14.5px; letter-spacing: 1px;">MENUGASKAN:</div>

        <!-- Kepada Penugasan -->
        <div class="spt-label-row">
            <div class="spt-label">Kepada</div>
            <div class="spt-separator">:</div>
            <div class="spt-content">
                <?php $no = 1; foreach ($pegawaiList as $peg) : ?>
                    <div style="display: flex; margin-bottom: 2px;">
                        <div style="width: 25px;"><?= $no++ ?>.</div>
                        <div style="width: 100px;">Nama</div>
                        <div style="width: 20px; text-align: center;">:</div>
                        <div style="flex-grow: 1; font-weight: normal;"><?= esc($peg['nama']) ?>;</div>
                    </div>
                    <div style="display: flex; margin-bottom: 2px; padding-left: 25px;">
                        <div style="width: 100px;">Jabatan</div>
                        <div style="width: 20px; text-align: center;">:</div>
                        <div style="flex-grow: 1;"><?= esc($peg['jabatan']) ?>;</div>
                    </div>
                    <div style="display: flex; margin-bottom: 12px; padding-left: 25px;">
                        <div style="width: 100px;">NIP</div>
                        <div style="width: 20px; text-align: center;">:</div>
                        <div style="flex-grow: 1;"><?= esc($peg['nip']) ?>;</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Untuk Penugasan -->
        <div class="spt-label-row">
            <div class="spt-label">Untuk</div>
            <div class="spt-separator">:</div>
            <div class="spt-content">
                <?= esc($suratTugas['maksud']) ?>
            </div>
        </div>

        <!-- Di Penugasan -->
        <div class="spt-label-row">
            <div class="spt-label">Di</div>
            <div class="spt-separator">:</div>
            <div class="spt-content">
                <?= esc($suratTugas['tujuan']) ?><br>
                <?= $durasi ?> (<?= terbilangDurasi($durasi) ?>) Hari, dari tanggal <?= tanggalIndo($suratTugas['tanggal_mulai']) ?> sampai tanggal <?= tanggalIndo($suratTugas['tanggal_selesai']) ?>
            </div>
        </div>

        <!-- Penandatangan -->
        <div class="spt-footer-container">
            <div class="spt-footer-box">
                <div>Karang Baru, <?= tanggalIndo($suratTugas['tanggal_surat']) ?></div>
                <div style="font-weight: normal; line-height: 1.3; position: relative;">
                    <?php if ($pejabat['status'] === 'Plt.' || $pejabat['status'] === 'Plh.') : ?>
                        <div style="position: absolute; right: 100%; margin-right: 10px; white-space: nowrap;">
                            <?= esc($pejabat['status']) ?>
                        </div>
                    <?php endif; ?>
                    <?php 
                        $raw_jabatan = str_replace('&', 'dan', $pejabat['jabatan']);
                        $jabatan_clean = esc($raw_jabatan);
                        
                        $target1 = esc("Kepala Dinas Pemberdayaan Masyarakat dan Kampung, Pemberdayaan Perempuan dan Keluarga Berencana Kabupaten Aceh Tamiang");
                        $replace1 = "Kepala Dinas Pemberdayaan Masyarakat<br>dan Kampung, Pemberdayaan Perempuan<br>dan Keluarga Berencana<br>Kabupaten Aceh Tamiang";
                        
                        $target2 = esc("Kepala Dinas Pemberdayaan Masyarakat dan Kampung, Pemberdayaan Perempuan dan Keluarga Berencana");
                        $replace2 = "Kepala Dinas Pemberdayaan Masyarakat<br>dan Kampung, Pemberdayaan Perempuan<br>dan Keluarga Berencana";
                        
                        $jabatan_clean = str_ireplace($target1, $replace1, $jabatan_clean);
                        $jabatan_clean = str_ireplace($target2, $replace2, $jabatan_clean);
                    ?>
                    <?php if ($pejabat['status'] === 'Atas Nama') : ?>
                        <?php 
                            $jabatan_text = $jabatan_clean;
                            $jabatan_text = preg_replace('/Kabupaten Aceh Tamiang,\s*/i', 'Kabupaten Aceh Tamiang<br>', $jabatan_text);
                            $jabatan_text = preg_replace('/BUPATI ACEH TAMIANG,\s*/i', 'BUPATI ACEH TAMIANG<br>', $jabatan_text);
                            
                            if (strpos($jabatan_text, '<br>') === false && strpos($jabatan_text, ',') !== false) {
                                $parts = explode(',', $jabatan_text, 2);
                                $jabatan_text = trim($parts[0]) . '<br>' . trim($parts[1]);
                            }
                        ?>
                        <div style="position: absolute; right: 100%; margin-right: 8px; white-space: nowrap;">a.n.</div>
                        <div style="text-align: left;"><?= $jabatan_text ?></div>
                    <?php else : ?>
                        <?php
                            if (strpos($jabatan_clean, '<br>') !== false) {
                                $jabatan_final = $jabatan_clean;
                            } else {
                                $jabatan_parts = explode(' Kabupaten Aceh Tamiang', $jabatan_clean);
                                $jabatan_utama = $jabatan_parts[0];
                                $kabupaten = count($jabatan_parts) > 1 ? 'Kabupaten Aceh Tamiang' . $jabatan_parts[1] : '';
                                $jabatan_final = $jabatan_utama . ($kabupaten ? '<br>' . $kabupaten : '');
                            }
                        ?>
                        <div style="text-align: left;"><?= $jabatan_final ?></div>
                    <?php endif; ?>
                </div>
                <div style="height: 75px;"></div>
                <div style="font-weight: bold; text-decoration: underline;"><?= esc($pejabat['nama']) ?></div>
                <div><?= esc($pejabat['pangkat']) ?></div>
                <div>NIP. <?= esc($pejabat['nip']) ?></div>
                <?php if ($pejabat['status'] === 'Plh.' && !empty($pejabat['nomor_nd'])) : ?>
                    <div style="font-size: 13px; line-height: 1.2; margin-top: 5px;">
                        ND. Nomor <?= esc($pejabat['nomor_nd']) ?><br>
                        Tanggal <?= !empty($pejabat['tanggal_nd']) ? tanggalIndo($pejabat['tanggal_nd']) : '' ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
