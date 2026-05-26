<?php
function terbilangDurasi($number) {
    $words = [
        1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima',
        6 => 'Enam', 7 => 'Tujuh', 8 => 'Delapan', 9 => 'Sembilan', 10 => 'Sepuluh',
        11 => 'Sebelas', 12 => 'Dua Belas', 13 => 'Tiga Belas', 14 => 'Empat Belas', 15 => 'Lima Belas'
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
            padding: 7.5mm;
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

        /* Judul SPD */
        .judul-spd {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .nomor-spd {
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        /* Tabel SPD */
        .table-spd {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        .table-spd th, .table-spd td {
            border: 1px solid #000000;
            padding: 6px 8px;
            vertical-align: top;
        }

        .table-spd td.no-col {
            width: 35px;
            text-align: center;
        }

        .table-spd td.label-col {
            width: 250px;
        }

        /* Tabel Pengikut */
        .table-pengikut {
            width: 100%;
            border-collapse: collapse;
            margin: 0; /* Rapikan garis kelebihan */
            border: none;
        }
        .table-pengikut th, .table-pengikut td {
            border: none;
            padding: 6px 8px;
        }
        .table-pengikut th {
            border-bottom: 1px solid #000000;
            font-weight: normal;
        }

        /* Tanda Tangan */
        .ttd-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
            font-size: 13.5px;
            line-height: 1.4;
        }

        .ttd-box {
            width: 320px;
            text-align: left;
        }

        /* Desain Halaman 2 SPPD (Visum/Stempel) */
        .table-visum {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .table-visum td {
            border: 1px solid #000000;
            padding: 8px;
            vertical-align: top;
            width: 50%;
            height: 110px;
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
                padding: 7.5mm !important;
                padding-top: 6mm !important; /* Batas atas tetap 0.6 cm */
                width: 215mm;
                min-height: 330mm;
                box-sizing: border-box;
            }
            .page-break {
                page-break-before: always;
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
            <h6 class="m-0" style="font-weight: 700; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Dokumen SPD Siap Cetak (2 Halaman)</h6>
            <small class="text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">SPD Halaman 1 (Rincian) & Halaman 2 (Stempel/Visum) | Margin: 0.75 cm | Atas Kop: 0.6 cm</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <i data-lucide="printer" class="me-1"></i> Cetak SPD
            </button>
            <button onclick="window.close()" class="btn btn-outline-secondary" style="font-weight:600; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Tutup Halaman
            </button>
        </div>
    </div>

    <?php foreach ($allSppd as $index => $sppd) : ?>
    <?php
    $pengikut = array_filter($allPegawaiSPT, function($p) use ($sppd) {
        return $p['id_pegawai'] != $sppd['id_pegawai'];
    });
    ?>
    <!-- HALAMAN 1: RINCIAN SURAT PERJALANAN DINAS -->
    <div class="paper <?= $index > 0 ? 'page-break' : '' ?>">
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

        <!-- Lembar & Nomor Kertas (Float Kanan Atas, Pindah di Bawah Kop) -->
        <div style="float: right; text-align: left; font-size: 12px; font-family: 'Bookman Old Style', serif; line-height: 1.3; margin-bottom: 10px;">
            Lembar ke : 1<br>
            Kode No   : <br>
            Nomor     : <?= esc($sppd['nomor_surat']) ?>
        </div>
        <div style="clear: both;"></div>

        <!-- Judul SPPD -->
        <div class="text-center">
            <div class="judul-spd">SURAT PERJALANAN DINAS (SPD)</div>
            <div class="nomor-spd">Nomor : <?= esc($sppd['nomor_surat']) ?></div>
        </div>

        <!-- Tabel Perincian SPPD -->
        <table class="table-spd">
            <tbody>
                <tr>
                    <td class="no-col">1.</td>
                    <td class="label-col">Pengguna Anggaran</td>
                    <td><?= esc($pejabat['nama']) ?></td>
                </tr>
                <tr>
                    <td class="no-col">2.</td>
                    <td class="label-col">Nama / NIP Pegawai yang melaksanakan perjalanan dinas</td>
                    <td>
                        <?= esc($sppd['nama_pegawai']) ?><br>
                        NIP. <?= esc($sppd['nip']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="no-col">3.</td>
                    <td class="label-col">
                        a. Pangkat<br>
                        b. Jabatan / Instansi<br>
                        c. Tingkat biaya perjalanan dinas
                    </td>
                    <td>
                        a. <?= esc($sppd['pangkat']) ?> (<?= esc($sppd['golongan']) ?>)<br>
                        b. <?= esc($sppd['jabatan']) ?> / DPMKPPKB<br>
                        c. <?= esc($sppd['tingkat_biaya']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="no-col">4.</td>
                    <td class="label-col">Maksud Perjalanan Dinas</td>
                    <td><?= esc($sppd['maksud_dinas']) ?></td>
                </tr>
                <tr>
                    <td class="no-col">5.</td>
                    <td class="label-col">Alat angkutan yang digunakan</td>
                    <td>Kendaraan Umum</td>
                </tr>
                <tr>
                    <td class="no-col">6.</td>
                    <td class="label-col">
                        a. Tempat berangkat<br>
                        b. Tempat tujuan
                    </td>
                    <td>
                        a. Karang Baru<br>
                        b. <?= esc($sppd['tujuan_dinas']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="no-col">7.</td>
                    <td class="label-col">
                        a. Lamanya perjalanan dinas<br>
                        b. Tanggal berangkat<br>
                        c. Tanggal harus Kembali / tiba ditempat baru *)
                    </td>
                    <td>
                        a. <?= $durasi ?> (<?= terbilangDurasi($durasi) ?>) Hari<br>
                        b. <?= tanggalIndo($sppd['tanggal_mulai']) ?><br>
                        c. <?= tanggalIndo($sppd['tanggal_selesai']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="no-col">8.</td>
                    <td class="label-col" style="padding: 0; vertical-align: middle;">
                        <div style="padding: 6px 8px;">Pengikut: Nama</div>
                    </td>
                    <td style="padding: 0;">
                        <table class="table-pengikut">
                            <thead>
                                <tr>
                                    <th style="border-right: 1px solid #000; width: 50%; padding-left: 8px;">Nama</th>
                                    <th style="border-right: 1px solid #000; width: 25%; padding-left: 8px;">Tanggal Lahir</th>
                                    <th style="padding-left: 8px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border-right: 1px solid #000; height: 35px;"></td>
                                    <td style="border-right: 1px solid #000; height: 35px;"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="no-col">9.</td>
                    <td class="label-col">
                        Pembebanan Anggaran<br>
                        a. Instansi<br>
                        b. Akun
                    </td>
                    <td>
                        <br>
                        a. DPMKPPKB<br>
                        b.
                    </td>
                </tr>
                <tr>
                    <td class="no-col">10.</td>
                    <td class="label-col">Keterangan lain-lain</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>

        <!-- Keterangan Coretan & Footer TTD -->
        <div style="font-size: 11px; font-style: italic;">*coret yang tidak perlu</div>

        <div class="ttd-container">
            <div class="ttd-box">
                <div>Dikeluarkan di : Karang Baru</div>
                <div class="mb-3">Tanggal : <?= tanggalIndo($sppd['tanggal_surat']) ?></div>
                <div style="font-weight: bold; text-transform: uppercase;">
                    PENGGUNA ANGGARAN
                </div>
                <div style="height: 65px;"></div> <!-- Area Tanda Tangan -->
                <div style="font-weight: bold; text-decoration: underline;"><?= esc($pejabat['nama']) ?></div>
                <div>NIP. <?= esc($pejabat['nip']) ?></div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 2: VISUM / STEMPEL KELUAR-MASUK -->
    <div class="paper page-break">
        <!-- Tabel Visum Keberangkatan & Kedatangan -->
        <?php
        $dests = [];
        if (!empty($destinations)) {
            foreach ($destinations as $d) {
                if (!empty(trim($d['tujuan']))) {
                    $dests[] = trim($d['tujuan']);
                }
            }
        }
        if (empty($dests)) {
            $dests[] = !empty($sppd['tujuan_dinas']) ? $sppd['tujuan_dinas'] : 'Tujuan';
        }
        $total_dest = count($dests);
        ?>
        <table class="table-visum">
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <b>I. Berangkat dari</b> : Karang Baru<br>
                        <b>Ke</b> : <?= esc($dests[0]) ?><br>
                        <b>Pada Tanggal</b> : <?= tanggalIndo($sppd['tanggal_mulai']) ?><br>
                        <b>Kepala</b>
                        <div style="height: 45px;"></div>
                        <b><u><?= esc($pejabat['nama']) ?></u></b><br>
                        NIP. <?= esc($pejabat['nip']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>II. Tiba di</b> : <?= esc($dests[0]) ?><br>
                        <b>Pada Tanggal</b> : <?= tanggalIndo($sppd['tanggal_mulai']) ?>
                    </td>
                    <td>
                        <b>Berangkat dari</b> : <?= esc($dests[0]) ?><br>
                        <b>Ke</b> : <?= $total_dest > 1 ? esc($dests[1]) : 'Karang Baru' ?><br>
                        <b>Pada Tanggal</b> : <?= $total_dest > 1 ? '' : tanggalIndo($sppd['tanggal_selesai']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>III. Tiba di</b> : <?= $total_dest > 1 ? esc($dests[1]) : '' ?><br>
                        <b>Pada Tanggal</b> : 
                    </td>
                    <td>
                        <b>Berangkat dari</b> : <?= $total_dest > 1 ? esc($dests[1]) : '' ?><br>
                        <b>Ke</b> : <?= $total_dest > 2 ? esc($dests[2]) : ($total_dest > 1 ? 'Karang Baru' : '') ?><br>
                        <b>Pada Tanggal</b> : <?= ($total_dest > 1 && $total_dest == 2) ? tanggalIndo($sppd['tanggal_selesai']) : '' ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>IV. Tiba di</b> : <?= $total_dest > 2 ? esc($dests[2]) : '' ?><br>
                        <b>Pada Tanggal</b> : 
                    </td>
                    <td>
                        <b>Berangkat dari</b> : <?= $total_dest > 2 ? esc($dests[2]) : '' ?><br>
                        <b>Ke</b> : <?= $total_dest > 3 ? esc($dests[3]) : ($total_dest > 2 ? 'Karang Baru' : '') ?><br>
                        <b>Pada Tanggal</b> : <?= ($total_dest > 2 && $total_dest == 3) ? tanggalIndo($sppd['tanggal_selesai']) : '' ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>V. Tiba di</b> : <?= $total_dest > 3 ? esc($dests[3]) : '' ?><br>
                        <b>Pada Tanggal</b> : 
                    </td>
                    <td>
                        <b>VI. Berangkat dari</b> : <?= $total_dest > 4 ? esc($dests[4]) : ($total_dest > 3 ? esc($dests[3]) : '') ?><br>
                        <b>Ke</b> : <?= $total_dest > 3 ? 'Karang Baru' : '' ?><br>
                        <b>Pada Tanggal</b> : <?= $total_dest > 3 ? tanggalIndo($sppd['tanggal_selesai']) : '' ?><br>
                        <b>Kepala</b>
                    </td>
                </tr>
                <tr>
                    <td style="height: 80px;"></td>
                    <td style="font-size: 11px; height: 80px; text-align: justify; line-height: 1.3;">
                        Telah diperiksa, dengan keterangan bahwa perjalanan tersebut diatas benar dilakukan atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Catatan Lain-lain -->
        <div style="border: 1px solid #000; padding: 6px 10px; font-size: 12px; margin-bottom: 10px;">
            <b>VII. Catatan Lain-lain:</b>
        </div>

        <!-- Perhatian -->
        <div style="border: 1px solid #000; padding: 10px; font-size: 11.5px; text-align: justify; line-height: 1.4; margin-bottom: 25px;">
            <b>VIII. Perhatian:</b><br>
            PA yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian, dan kealpaannya.
        </div>

        <!-- Tanda Tangan Footer PA Halaman 2 -->
        <div class="ttd-container" style="margin-top: 15px;">
            <div class="ttd-box">
                <div style="font-weight: bold; text-transform: uppercase; margin-bottom: 60px;">
                    PENGGUNA ANGGARAN
                </div>
                <div style="font-weight: bold; text-decoration: underline;"><?= esc($pejabat['nama']) ?></div>
                <div>NIP. <?= esc($pejabat['nip']) ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</body>
</html>
