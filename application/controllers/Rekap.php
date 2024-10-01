<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rekap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model yang sesuai untuk data rekap cuti
        $this->load->model('Rekap_model');
        $this->load->helper('url');
    }

    // Menampilkan rekap cuti untuk admin
    public function view_admin() {
        // Ambil data cuti dan rekap dari model
        $data['cuti'] = $this->Rekap_model->get_data_cuti(); // Data cuti untuk rekap
        $data['rekap_cuti'] = $this->Rekap_model->get_all_rekap(); // Semua data rekap cuti

        // Load view rekap cuti di admin
        $this->load->view('admin/rekap_cuti', $data);
    }

    // Fungsi untuk ekspor rekap cuti ke Excel
    public function exportExcel() {
        // Ambil data rekap cuti dari model
        $rekapCuti = $this->Rekap_model->get_all_rekap();

        // Membuat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Pegawai');
        $sheet->setCellValue('C1', 'Jenis Cuti');
        $sheet->setCellValue('D1', 'Tanggal Mulai');
        $sheet->setCellValue('E1', 'Tanggal Berakhir');
        $sheet->setCellValue('F1', 'Lama Cuti (Hari)');
        $sheet->setCellValue('G1', 'Status');

        // Mulai dari baris kedua
        $row = 2;
        $no = 1;

        // Looping data untuk diisi ke sheet
        foreach ($rekapCuti as $rekap) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $rekap['nama_pegawai']); // Nama pegawai
            $sheet->setCellValue('C' . $row, $rekap['jenis_cuti']);   // Jenis cuti
            $sheet->setCellValue('D' . $row, $rekap['mulai']);        // Tanggal mulai
            $sheet->setCellValue('E' . $row, $rekap['berakhir']);     // Tanggal berakhir
            $sheet->setCellValue('F' . $row, $rekap['lama_cuti']);    // Lama cuti
            $sheet->setCellValue('G' . $row, $rekap['status']);       // Status cuti
            $row++;
        }

        // Membuat writer untuk export Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_cuti_' . date('Ymd') . '.xlsx';

        // Pengaturan header untuk download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        // Simpan dan kirim file Excel ke browser
        $writer->save('php://output');
    }
}