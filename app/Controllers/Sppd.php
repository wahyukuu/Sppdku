<?php

namespace App\Controllers;

use App\Models\SppdModel;
use App\Models\SuratTugasModel;
use App\Models\PegawaiModel;
use App\Models\BiayaModel;

class Sppd extends BaseController
{
    protected $sppdModel;
    protected $suratTugasModel;
    protected $pegawaiModel;
    protected $biayaModel;

    public function __construct()
    {
        $this->sppdModel       = new SppdModel();
        $this->suratTugasModel = new SuratTugasModel();
        $this->pegawaiModel    = new PegawaiModel();
        $this->biayaModel      = new BiayaModel();
    }

    /**
     * Menampilkan halaman daftar semua SPPD.
     * Melakukan join ke tabel surat_tugas dan pegawai untuk menampilkan nomor surat,
     * tanggal mulai/selesai, nama pegawai, dan NIP.
     * Mengarahkan ke view `sppd/index`.
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $sppd = $this->sppdModel
            ->select('sppd.*, surat_tugas.nomor_surat, surat_tugas.tanggal_mulai, surat_tugas.tanggal_selesai, pegawai.nama as nama_pegawai, pegawai.nip')
            ->join('surat_tugas', 'surat_tugas.id = sppd.id_surat_tugas')
            ->join('pegawai', 'pegawai.id_pegawai = sppd.id_pegawai')
            ->orderBy('sppd.created_at', 'DESC')
            ->findAll();

        $data = [
            'title'      => 'SPPD Penerbitan | SPPDKU',
            'activeMenu' => 'sppd',
            'sppd'       => $sppd,
        ];

        return view('sppd/index', $data);
    }

    /**
     * Mencetak dokumen SPPD secara kolektif berdasarkan ID salah satu SPPD.
     * Mengambil semua SPPD yang terkait dengan surat tugas yang sama,
     * lalu menggabungkan data pegawai, pejabat Pengguna Anggaran (PA),
     * daftar tujuan, dan menghitung durasi hari (dengan opsi hitung Sabtu/Minggu).
     * Data dikirimkan ke view `sppd/print` untuk dicetak.
     */
    public function print($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data SPPD utama berdasarkan ID yang dipilih
        $sppdUtama = $this->sppdModel->find($id);
        if (!$sppdUtama) {
            return redirect()->to(base_url('sppd'))->with('error', 'Dokumen SPPD tidak ditemukan.');
        }

        // Ambil semua SPPD yang satu surat tugas, lengkap dengan data pegawai dan surat tugas
        $allSppd = $this->sppdModel
            ->select('sppd.*, 
                surat_tugas.nomor_surat, 
                surat_tugas.dasar_surat, 
                surat_tugas.maksud as maksud_dinas, 
                surat_tugas.tujuan as tujuan_dinas, 
                surat_tugas.tanggal_mulai, 
                surat_tugas.tanggal_selesai, 
                surat_tugas.tanggal_surat,
                surat_tugas.id_pejabat_ttd,
                surat_tugas.hitung_sabtu,
                surat_tugas.hitung_minggu,
                pegawai.nama as nama_pegawai, 
                pegawai.nip, 
                pegawai.pangkat, 
                pegawai.golongan, 
                pegawai.jabatan, 
                pegawai.unit_kerja, 
                pegawai.tingkat_biaya')
            ->join('surat_tugas', 'surat_tugas.id = sppd.id_surat_tugas')
            ->join('pegawai', 'pegawai.id_pegawai = sppd.id_pegawai')
            ->where('sppd.id_surat_tugas', $sppdUtama['id_surat_tugas'])
            ->findAll();

        if (empty($allSppd)) {
            return redirect()->to(base_url('sppd'))->with('error', 'Dokumen SPPD tidak ditemukan.');
        }

        // Gunakan data dari SPPD pertama sebagai referensi utama
        $sppd = $allSppd[0];



        // Ambil pejabat dengan status 'Pengguna Anggaran' secara otomatis
        $pejabatModel = new \App\Models\PejabatModel();
        $pejabatPA = $pejabatModel
            ->select('pegawai.nama, pegawai.nip, pegawai.pangkat, pegawai.golongan, pejabat.jabatan as jabatan_pejabat, pejabat.status')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('pejabat.status', 'Pengguna Anggaran')
            ->first();

        // Jika tidak ditemukan 'Pengguna Anggaran', fallback ke pejabat_ttd dari surat tugas
        if (!$pejabatPA) {
            $pejabatPA = $this->pegawaiModel
                ->select('pegawai.nama, pegawai.nip, pegawai.pangkat, pegawai.golongan, pejabat.jabatan as jabatan_pejabat, pejabat.status')
                ->join('pejabat', 'pejabat.id_pegawai = pegawai.id_pegawai')
                ->where('pejabat.id', $sppd['id_pejabat_ttd'])
                ->first();
        }
        $pejabat = $pejabatPA;

        // Hitung durasi hari
        $tglMulai = new \DateTime($sppd['tanggal_mulai']);
        $tglSelesai = new \DateTime($sppd['tanggal_selesai']);
        $durasi = 0;
        $currentDate = clone $tglMulai;
        
        $hitungSabtu = !empty($sppd['hitung_sabtu']);
        $hitungMinggu = !empty($sppd['hitung_minggu']);

        while ($currentDate <= $tglSelesai) {
            $dayOfWeek = $currentDate->format('N'); // 1-5 Mon-Fri, 6 Sat, 7 Sun
            
            if ($dayOfWeek == 6 && !$hitungSabtu) {
                // Jangan dihitung
            } elseif ($dayOfWeek == 7 && !$hitungMinggu) {
                // Jangan dihitung
            } else {
                $durasi++;
            }
            $currentDate->modify('+1 day');
        }

        // Ambil daftar tujuan perjalanan dinas dari tabel surat_tugas_tujuan
        $tujuanModel = new \App\Models\SuratTugasTujuanModel();
        $destinations = $tujuanModel
            ->where('id_surat_tugas', $sppd['id_surat_tugas'])
            ->orderBy('id', 'ASC')
            ->findAll();

        // Ambil semua pegawai yang ditugaskan dalam surat tugas ini (untuk halaman print)
        $allPegawaiSPT = $this->pegawaiModel
            ->select('pegawai.*')
            ->join('surat_tugas_pegawai', 'surat_tugas_pegawai.id_pegawai = pegawai.id_pegawai')
            ->where('surat_tugas_pegawai.id_surat_tugas', $sppd['id_surat_tugas'])
            ->findAll();

        $data = [
            'title'        => 'Cetak SPPD Kolektif',
            'allSppd'      => $allSppd,
            'pejabat'      => $pejabat,
            'durasi'       => $durasi,
            'destinations' => $destinations,
            'allPegawaiSPT'=> $allPegawaiSPT,
        ];

        return view('sppd/print', $data);
    }

    /**
     * Mencetak dokumen Kwitansi untuk satu SPPD berdasarkan ID.
     * Mengambil data SPPD beserta pegawai dan surat tugas terkait.
     * Kemudian mengambil pejabat PA (Pengguna Anggaran) dan Bendahara Pengeluaran.
     * Menghitung rincian biaya berdasarkan tingkat biaya pegawai, jenis perjalanan (DL/DD),
     * tujuan dinas, opsi hotel (full/30%), dan durasi hari.
     * - Dinas Dalam (DD): hanya uang harian.
     * - Dinas Luar (DL): uang transport + penginapan + harian + representative.
     * Hasil konversi total biaya ke terbilang juga dihitung.
     * Data dikirimkan ke view `sppd/kwitansi`.
     */
    public function kwitansi($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data SPPD lengkap dengan join ke surat_tugas dan pegawai
        $sppd = $this->sppdModel
            ->select('sppd.*, 
                surat_tugas.nomor_surat, 
                surat_tugas.maksud as maksud_dinas, 
                surat_tugas.tujuan as tujuan_dinas, 
                surat_tugas.tanggal_mulai, 
                surat_tugas.tanggal_selesai, 
                surat_tugas.tanggal_surat,
                surat_tugas.id_pejabat_ttd,
                surat_tugas.hitung_sabtu,
                surat_tugas.hitung_minggu,
                pegawai.nama as nama_pegawai, 
                pegawai.nip, 
                pegawai.pangkat, 
                pegawai.golongan, 
                pegawai.jabatan, 
                pegawai.tingkat_biaya')
            ->join('surat_tugas', 'surat_tugas.id = sppd.id_surat_tugas')
            ->join('pegawai', 'pegawai.id_pegawai = sppd.id_pegawai')
            ->where('sppd.id', $id)
            ->first();

        if (!$sppd) {
            return redirect()->to(base_url('sppd'))->with('error', 'Dokumen SPPD tidak ditemukan.');
        }

        // Ambil pejabat dengan status 'Pengguna Anggaran' secara otomatis
        $pejabatModel = new \App\Models\PejabatModel();
        $pejabatPA = $pejabatModel
            ->select('pegawai.nama, pegawai.nip, pejabat.jabatan as jabatan_pejabat, pejabat.status')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('pejabat.status', 'Pengguna Anggaran')
            ->first();

        // Ambil pejabat dengan status 'Bendahara Pengeluaran'
        $bendahara = $pejabatModel
            ->select('pegawai.nama, pegawai.nip, pejabat.jabatan as jabatan_pejabat, pejabat.status')
            ->join('pegawai', 'pegawai.id_pegawai = pejabat.id_pegawai')
            ->where('pejabat.status', 'Bendahara Pengeluaran')
            ->first();

        // Jika tidak ditemukan 'Pengguna Anggaran', fallback ke pejabat_ttd dari surat tugas
        if (!$pejabatPA) {
            $pejabatPA = $this->pegawaiModel
                ->select('pegawai.nama, pegawai.nip, pejabat.jabatan as jabatan_pejabat, pejabat.status')
                ->join('pejabat', 'pejabat.id_pegawai = pegawai.id_pegawai')
                ->where('pejabat.id', $sppd['id_pejabat_ttd'])
                ->first();
        }
        $pejabat = $pejabatPA;

        // Hitung durasi hari
        $tglMulai = new \DateTime($sppd['tanggal_mulai']);
        $tglSelesai = new \DateTime($sppd['tanggal_selesai']);
        $durasi = 0;
        $currentDate = clone $tglMulai;
        
        $hitungSabtu = !empty($sppd['hitung_sabtu']);
        $hitungMinggu = !empty($sppd['hitung_minggu']);
        
        while ($currentDate <= $tglSelesai) {
            $dayOfWeek = $currentDate->format('N'); // 1-5 Mon-Fri, 6 Sat, 7 Sun
            
            if ($dayOfWeek == 6 && !$hitungSabtu) {
                // Jangan dihitung
            } elseif ($dayOfWeek == 7 && !$hitungMinggu) {
                // Jangan dihitung
            } else {
                $durasi++;
            }
            $currentDate->modify('+1 day');
        }

        // Ambil rincian biaya berdasarkan tingkat biaya pegawai, tipe perjalanan (jenis DL/DD), dan tujuan
        $biaya = $this->biayaModel
            ->where('tingkat', $sppd['tingkat_biaya'])
            ->where('jenis', $sppd['jenis'])
            ->where('tujuan', $sppd['tujuan_dinas'])
            ->first();

        // Jika tidak ada biaya spesifik tujuan, cari yang umum (tujuan kosong/null)
        if (!$biaya) {
            $biaya = $this->biayaModel
                ->where('tingkat', $sppd['tingkat_biaya'])
                ->where('jenis', $sppd['jenis'])
                ->groupStart()
                    ->where('tujuan', null)
                    ->orWhere('tujuan', '')
                ->groupEnd()
                ->first();
        }

        // Jika biaya tingkat tsb tidak ada, gunakan default tingkat D atau angka nol
        if (!$biaya) {
            $biaya = [
                'transport'      => 0,
                'penginapan'     => 0,
                'harian'         => 0,
                'representative' => 0
            ];
        }

        // Ambil opsi hotel dari query parameter (?hotel=full atau ?hotel=30), default 'full'
        $hotelOption = $this->request->getGet('hotel') ?? 'full';
        
        // Hitung total uang harian: tarif harian x jumlah hari
        $totalHarian = $biaya['harian'] * $durasi;

        // Hitung tarif penginapan (jika opsi 30%, gunakan 30% dari tarif normal)
        $tarifPenginapan = $biaya['penginapan'];
        if ($hotelOption === '30') {
            $tarifPenginapan = $tarifPenginapan * 0.3;
        }

        // Jumlah malam menginap = durasi hari - 1 (minimal 0)
        $malam = max(0, $durasi - 1);
        $totalPenginapan = $tarifPenginapan * $malam;
        
        // Hitung total biaya berdasarkan jenis perjalanan
        // DD (Dinas Dalam): hanya uang harian
        // DL (Dinas Luar): transport + penginapan + harian + representative
        if ($sppd['jenis'] === 'DD') {
            $totalBiaya = $totalHarian;
        } else {
            $totalBiaya = $biaya['transport'] + $totalPenginapan + $totalHarian + $biaya['representative'];
        }

        $data = [
            'title'           => 'Cetak Kwitansi - ' . $sppd['nama_pegawai'],
            'sppd'            => $sppd,
            'pejabat'         => $pejabat,
            'bendahara'       => $bendahara,
            'biaya'           => $biaya,
            'durasi'          => $durasi,
            'malam'           => $malam,
            'total_harian'    => $totalHarian,
            'tarif_penginapan'=> $tarifPenginapan,
            'total_penginapan'=> $totalPenginapan,
            'hotel_option'    => $hotelOption,
            'total_biaya'     => $totalBiaya,
            'terbilang'       => $this->terbilang($totalBiaya) . ' Rupiah',
        ];

        return view('sppd/kwitansi', $data);
    }

    /**
     * Menghapus dokumen SPPD berdasarkan ID.
     * Setelah dihapus, diarahkan kembali ke halaman daftar SPPD.
     */
    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $this->sppdModel->delete($id);
        return redirect()->to(base_url('sppd'))->with('success', 'Dokumen SPPD berhasil dihapus.');
    }

    /**
     * Helper function (private): Mengkonversi angka numerik menjadi kata-kata Bahasa Indonesia.
     * Contoh: 150000 -> "Seratus Lima Puluh Ribu"
     * Digunakan untuk field "Terbilang" pada kwitansi.
     * Menggunakan metode rekursif untuk membagi angka ke satuan, puluhan, ratusan,
     * ribu, juta, milyar, dan trilyun.
     *
     * @param int|float $nilai Angka yang ingin dikonversi
     * @return string Hasil konversi dalam Bahasa Indonesia
     */
    private function terbilang($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp  = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai / 10) . " Puluh" . $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai / 100) . " Ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai / 1000) . " Ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai / 1000000) . " Juta" . $this->terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->terbilang($nilai / 1000000000) . " Milyar" . $this->terbilang($nilai % 1000000000);
        } else if ($nilai < 1000000000000000) {
            $temp = $this->terbilang($nilai / 1000000000000) . " Trilyun" . $this->terbilang($nilai % 1000000000000);
        }     
        return trim($temp);
    }
}
