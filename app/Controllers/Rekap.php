<?php

namespace App\Controllers;

use App\Models\SuratTugasModel;
use App\Models\SuratTugasPegawaiModel;
use App\Models\SppdModel;
use App\Models\PegawaiModel;
use App\Models\BiayaModel;

class Rekap extends BaseController
{
    protected $suratTugasModel;
    protected $suratTugasPegawaiModel;
    protected $sppdModel;
    protected $pegawaiModel;
    protected $biayaModel;

    public function __construct()
    {
        $this->suratTugasModel        = new SuratTugasModel();
        $this->suratTugasPegawaiModel = new SuratTugasPegawaiModel();
        $this->sppdModel              = new SppdModel();
        $this->pegawaiModel           = new PegawaiModel();
        $this->biayaModel             = new BiayaModel();
    }

    /**
     * Halaman rekapitulasi perjalanan dinas dengan filter periode (bulan/tahun) dan jenis.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil filter dari query string
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $jenis = $this->request->getGet('jenis') ?? '';

        // Build query Surat Tugas
        $builder = $this->suratTugasModel
            ->select('surat_tugas.*, pegawai.nama as nama_pejabat')
            ->join('pejabat', 'pejabat.id = surat_tugas.id_pejabat_ttd')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('MONTH(surat_tugas.tanggal_surat)', (int)$bulan)
            ->where('YEAR(surat_tugas.tanggal_surat)', (int)$tahun)
            ->orderBy('surat_tugas.tanggal_surat', 'ASC');

        if (!empty($jenis)) {
            $builder->where('surat_tugas.jenis', $jenis);
        }

        $suratTugas = $builder->findAll();

        // Ambil pegawai dan hitung estimasi biaya tiap surat tugas
        $totalBiayaEstimasi = 0;
        $totalDL = 0;
        $totalDD = 0;
        $totalSppd = 0;

        foreach ($suratTugas as &$st) {
            // Pegawai list
            $pegawaiList = $this->suratTugasPegawaiModel
                ->select('pegawai.nama, pegawai.tingkat_biaya')
                ->join('pegawai', 'pegawai.id_pegawai = surat_tugas_pegawai.id_pegawai')
                ->where('id_surat_tugas', $st['id'])
                ->findAll();

            $st['pegawai'] = array_column($pegawaiList, 'nama');
            $st['jumlah_pegawai'] = count($pegawaiList);

            // Hitung durasi
            $start   = new \DateTime($st['tanggal_mulai']);
            $end     = new \DateTime($st['tanggal_selesai']);
            $durasi  = 0;
            $current = clone $start;
            while ($current <= $end) {
                $dow = $current->format('N');
                if ($dow == 6 && empty($st['hitung_sabtu'])) {
                    // skip
                } elseif ($dow == 7 && empty($st['hitung_minggu'])) {
                    // skip
                } else {
                    $durasi++;
                }
                $current->modify('+1 day');
            }
            $st['durasi'] = $durasi;

            // Estimasi biaya per surat tugas (jumlah semua pegawai)
            $biayaST = 0;
            foreach ($pegawaiList as $peg) {
                $biaya = $this->biayaModel
                    ->where('tingkat', $peg['tingkat_biaya'])
                    ->where('jenis', $st['jenis'])
                    ->groupStart()
                        ->where('tujuan', null)
                        ->orWhere('tujuan', '')
                    ->groupEnd()
                    ->first();

                if ($biaya) {
                    if ($st['jenis'] === 'DD') {
                        $biayaST += $biaya['harian'] * $durasi;
                    } else {
                        $malam    = max(0, $durasi - 1);
                        $biayaST += $biaya['transport'] + ($biaya['penginapan'] * $malam) + ($biaya['harian'] * $durasi) + $biaya['representative'];
                    }
                }
            }
            $st['estimasi_biaya'] = $biayaST;
            $totalBiayaEstimasi  += $biayaST;

            // Counter jenis
            if ($st['jenis'] === 'DL') $totalDL++;
            else $totalDD++;

            // Hitung SPPD (per pegawai)
            $totalSppd += $st['jumlah_pegawai'];
        }

        // Generate opsi tahun (5 tahun ke belakang s/d tahun ini)
        $tahunOps = [];
        for ($y = date('Y'); $y >= date('Y') - 5; $y--) {
            $tahunOps[] = $y;
        }

        $data = [
            'title'               => 'Rekap Perjalanan Dinas | SPPDKU',
            'activeMenu'          => 'rekap',
            'suratTugas'          => $suratTugas,
            'bulan'               => $bulan,
            'tahun'               => $tahun,
            'jenis'               => $jenis,
            'totalSuratTugas'     => count($suratTugas),
            'totalSppd'           => $totalSppd,
            'totalDL'             => $totalDL,
            'totalDD'             => $totalDD,
            'totalBiayaEstimasi'  => $totalBiayaEstimasi,
            'tahunOps'            => $tahunOps,
        ];

        return view('rekap/index', $data);
    }

    /**
     * Halaman cetak rekap perjalanan dinas (print-friendly).
     */
    public function cetakRekap()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil filter dari query string
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $jenis = $this->request->getGet('jenis') ?? '';

        $builder = $this->suratTugasModel
            ->select('surat_tugas.*, pegawai.nama as nama_pejabat')
            ->join('pejabat', 'pejabat.id = surat_tugas.id_pejabat_ttd')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('MONTH(surat_tugas.tanggal_surat)', (int)$bulan)
            ->where('YEAR(surat_tugas.tanggal_surat)', (int)$tahun)
            ->orderBy('surat_tugas.tanggal_surat', 'ASC');

        if (!empty($jenis)) {
            $builder->where('surat_tugas.jenis', $jenis);
        }

        $suratTugas = $builder->findAll();

        $totalBiayaEstimasi = 0;
        $no = 1;
        foreach ($suratTugas as &$st) {
            $st['no'] = $no++;
            $pegawaiList = $this->suratTugasPegawaiModel
                ->select('pegawai.nama, pegawai.tingkat_biaya')
                ->join('pegawai', 'pegawai.id_pegawai = surat_tugas_pegawai.id_pegawai')
                ->where('id_surat_tugas', $st['id'])
                ->findAll();

            $st['pegawai']        = array_column($pegawaiList, 'nama');
            $st['jumlah_pegawai'] = count($pegawaiList);

            $start   = new \DateTime($st['tanggal_mulai']);
            $end     = new \DateTime($st['tanggal_selesai']);
            $durasi  = 0;
            $current = clone $start;
            while ($current <= $end) {
                $dow = $current->format('N');
                if ($dow == 6 && empty($st['hitung_sabtu'])) {
                } elseif ($dow == 7 && empty($st['hitung_minggu'])) {
                } else {
                    $durasi++;
                }
                $current->modify('+1 day');
            }
            $st['durasi'] = $durasi;

            $biayaST = 0;
            foreach ($pegawaiList as $peg) {
                $biaya = $this->biayaModel
                    ->where('tingkat', $peg['tingkat_biaya'])
                    ->where('jenis', $st['jenis'])
                    ->groupStart()
                        ->where('tujuan', null)
                        ->orWhere('tujuan', '')
                    ->groupEnd()
                    ->first();

                if ($biaya) {
                    if ($st['jenis'] === 'DD') {
                        $biayaST += $biaya['harian'] * $durasi;
                    } else {
                        $malam    = max(0, $durasi - 1);
                        $biayaST += $biaya['transport'] + ($biaya['penginapan'] * $malam) + ($biaya['harian'] * $durasi) + $biaya['representative'];
                    }
                }
            }
            $st['estimasi_biaya'] = $biayaST;
            $totalBiayaEstimasi  += $biayaST;
        }

        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni',
            7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];

        $data = [
            'title'              => 'Cetak Rekap Perjalanan Dinas',
            'suratTugas'         => $suratTugas,
            'bulan'              => $bulan,
            'tahun'              => $tahun,
            'jenis'              => $jenis,
            'namaBulan'          => $namaBulan[(int)$bulan] ?? '',
            'totalBiayaEstimasi' => $totalBiayaEstimasi,
        ];

        return view('rekap/print', $data);
    }
}
