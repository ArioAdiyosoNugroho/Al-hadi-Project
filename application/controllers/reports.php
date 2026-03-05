<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_reports', 'reports');
        $this->load->model('M_classes', 'classes');
    }

    /**
     * Halaman utama laporan
     * Default: tampilkan bulan & tahun sekarang
     */
    public function index() {
        $bulan = $this->input->get('bulan') ?: date('n');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $data = [
            'title'          => 'Laporan Kebersihan',
            'content'        => 'pages/reports/index',
            'bulan'          => (int)$bulan,
            'tahun'          => (int)$tahun,
            'available'      => $this->reports->get_available_months(),
            'rekap'          => $this->reports->get_rekap_bulanan($bulan, $tahun),
            'ranking'        => $this->reports->get_ranking($bulan, $tahun),
            'summary'        => $this->reports->get_summary_bulanan($bulan, $tahun),
            'terbersih'      => $this->reports->get_kelas_terbersih($bulan, $tahun),
        ];
        $this->load->view('layouts/main', $data);
    }

    /**
     * Export PDF laporan bulanan
     * Menggunakan view HTML yang di-render lalu di-print via mPDF
     * Fallback: jika mPDF tidak ada, gunakan HTML print view
     */
public function export_pdf() {
    $bulan = $this->input->get('bulan') ?: date('n');
    $tahun = $this->input->get('tahun') ?: date('Y');
    $nama_bulan = $this->_nama_bulan((int)$bulan);

    $data = [
        'bulan'      => (int)$bulan,
        'tahun'      => (int)$tahun,
        'nama_bulan' => $nama_bulan,
        'rekap'      => $this->reports->get_rekap_bulanan($bulan, $tahun),
        'ranking'    => $this->reports->get_ranking($bulan, $tahun),
        'summary'    => $this->reports->get_summary_bulanan($bulan, $tahun),
        'terbersih'  => $this->reports->get_kelas_terbersih($bulan, $tahun),
        'detail'     => $this->reports->get_detail_bulanan($bulan, $tahun),
    ];

    $autoload = APPPATH . '../vendor/autoload.php';

    if (file_exists($autoload)) {
        // gunakan mPDF via composer
        require_once $autoload;

        // render view ke HTML
        $html = $this->load->view('pages/reports/eksport', $data, true);
        $html = trim($html);

        // konfigurasi mPDF: gunakan format A4-L (landscape)
        $mpdfConfig = [
            'mode' => 'utf-8',
            'format' => 'A4-L', // A4-L = A4 Landscape
            'margin_top' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_bottom' => 15,
            'shrink_tables_to_fit' => 1,
        ];

        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $filename = 'Laporan_Kebersihan_' . $nama_bulan . '_' . $tahun . '.pdf';
        $mpdf->SetTitle('Laporan Kebersihan ' . $nama_bulan . ' ' . $tahun);
        $mpdf->SetDisplayMode('fullpage');

        // Jika view mengandung inline CSS <style>, mPDF akan memprosesnya.
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'D'); // force download

    } else {
        // fallback: tampilkan HTML biasa (siap untuk cetak dari browser)
        $this->load->view('pages/reports/eksport', $data);
    }
}
    // ── Helper nama bulan Bahasa Indonesia ─────────────────────────────────
    private function _nama_bulan($n) {
        $bulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret',     4=>'April',
            5=>'Mei',     6=>'Juni',     7=>'Juli',       8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
        ];
        return $bulan[$n] ?? '';
    }
}
