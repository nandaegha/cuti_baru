<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_cuti');
        $this->load->model('m_user');
        $this->load->model('m_jenis_cuti');
        $this->load->model('Rekap_model');
    }

    // View untuk pimpinan berdasarkan role pimpinan1, pimpinan2, pimpinan3
    public function view_pimpinan() {
        // Cek apakah user sudah login dan memiliki peran sebagai pimpinan (pimpinan1, 2, atau 3)
        if ($this->session->userdata('logged_in') == true && in_array($this->session->userdata('id_role'), [3, 4, 5])) {
            $data['cuti'] = [];

            // Pimpinan1 (id_role = 4) dapat melihat semua cuti
            if ($this->session->userdata('id_role') == 3) {
                $data['cuti'] = $this->m_cuti->get_all_cuti()->result_array();
            }
            // Pimpinan2 (id_role = 5) mungkin hanya melihat cuti pada pegawai di departemennya atau kategori tertentu
            elseif ($this->session->userdata('id_role') == 4) {
                // Contoh: Pimpinan2 hanya melihat cuti dari pegawai departemen tertentu
                $id_departemen = $this->session->userdata('id_departemen');
                $data['cuti'] = $this->m_cuti->get_cuti_by_departemen($id_departemen)->result_array();
            }
            // Pimpinan3 (id_role = 6) mungkin hanya bisa melihat cuti yang sedang menunggu konfirmasi
            elseif ($this->session->userdata('id_role') == 5) {
                $data['cuti'] = $this->m_cuti->get_pending_cuti()->result_array();
            }

            $this->load->view('Cuti/view_pimpinan', $data);
        } else {
            // Jika user tidak login atau bukan pimpinan, redirect ke halaman login
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    // Aksi untuk menyetujui atau menolak cuti oleh pimpinan
    public function acc_cuti_pimpinan($status) {
        // Hanya pimpinan1, pimpinan2, dan pimpinan3 yang bisa melakukan approval
        if ($this->session->userdata('logged_in') == true && in_array($this->session->userdata('id_role'), [3, 4, 5])) {
            $id_cuti = $this->input->post("id_cuti");
            $id_user = $this->input->post("id_user");
            $alasan_verifikasi = $this->input->post("alasan_verifikasi");

            // Lakukan verifikasi cuti, apakah disetujui atau ditolak berdasarkan $status
            $hasil = $this->m_cuti->confirm_cuti($id_cuti, $status, $alasan_verifikasi);
            
            if ($hasil == false) {
                $this->session->set_flashdata('eror_input', 'eror_input');
            } else {
                $this->session->set_flashdata('input', 'input');
            }

            redirect('Cuti/view_pimpinan/'.$id_user);
        } else {
            // Jika bukan pimpinan, redirect ke halaman login
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    // View untuk pegawai
	public function view_pegawai($id_user) {
	    if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 1) {
	        $data['cuti'] = $this->m_cuti->get_all_cuti_by_id_user($id_user);
	        $data['pegawai'] = $this->m_user->get_pegawai_by_id($id_user);
	        $data['jenis_cuti'] = $this->m_jenis_cuti->get_all_jenis_cuti();

	        $this->load->view('pegawai/cuti', $data);
	    } else {
	        $this->session->set_flashdata('loggin_err', 'loggin_err');
	        redirect('Login/index');
	    }
	}
    
	public function view($id_user) {
	    // Fetch user data based on the user ID
	    $data['cuti'] = $this->m_cuti->get_all_cuti_by_id_user($id_user);
	    
	    // Ensure that you retrieve the specific cuti ID if it's available
	    if (!empty($data['cuti'])) {
	        foreach ($data['cuti'] as $cuti) {
	            $data['id_cuti'] = $cuti['id']; // Adjust according to your data structure
	            break; // Exit after getting the first cuti if there are multiple records
	        }
	    } else {
	        $data['id_cuti'] = null; // Set to null if no cuti is found
	    }

	    $data['id_user'] = $id_user; // Pass the user ID as well

	    $this->load->view('pegawai/cuti', $data);
	}

    // Hapus cuti untuk pegawai
	public function hapus_cuti($id_cuti) {
	    if ($this->m_cuti->delete_cuti($id_cuti)) {
	        $this->session->set_flashdata('hapus', 'Data Berhasil Dihapus');
	    } else {
	        $this->session->set_flashdata('eror_hapus', 'Data Gagal Dihapus');
	    }
	    redirect('pegawai/cuti');
	}
    // View untuk admin
    public function view_admin() {
        if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 2) {
            $data['cuti'] = $this->m_cuti->get_all_cuti()->result_array();
            $data['rekap_cuti'] = $this->Rekap_model->get_all_rekap();
            $this->load->view('admin/cuti', $data);
        } else {
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    // Hapus cuti untuk admin
    public function hapus_cuti_admin() {
        $id_cuti = $this->input->post("id_cuti");

        $hasil = $this->m_cuti->delete_cuti($id_cuti);
        
        if ($hasil == false) {
            $this->session->set_flashdata('eror_hapus', 'eror_hapus');
        } else {
            $this->session->set_flashdata('hapus', 'hapus');
        }

        redirect('Cuti/view_admin');
    }

	public function edit_cuti() {
	    $id_cuti = $this->input->post("id_cuti");
	    $alasan = $this->input->post("alasan");
	    $jenis_cuti = $this->input->post("jenis_cuti");
	    $tgl_diajukan = $this->input->post("tgl_diajukan");
	    $mulai = $this->input->post("mulai");
	    $berakhir = $this->input->post("berakhir");

	    $id_user = $this->session->userdata('id_user');
	    $id_role = $this->session->userdata('id_role');

	    // Admin bisa mengedit semua cuti, pegawai hanya cuti mereka sendiri
	    if ($id_role == 2) { // Admin
	        $hasil = $this->m_cuti->update_cuti($alasan, $jenis_cuti, $tgl_diajukan, $mulai, $berakhir, $id_cuti);
	        if ($hasil == false) {
	            $this->session->set_flashdata('eror_edit', 'eror_edit');
	        } else {
	            $this->session->set_flashdata('edit', 'edit');
	        }
	        redirect('Cuti/view_admin');
	    } elseif ($id_role == 1) { // Pegawai
	        $cuti_pegawai = $this->m_cuti->get_cuti_by_id($id_cuti)->row_array();

	        if ($cuti_pegawai['id_user'] == $id_user) {
	            $hasil = $this->m_cuti->update_cuti($alasan, $jenis_cuti, $tgl_diajukan, $mulai, $berakhir, $id_cuti);
	            if ($hasil == false) {
	                $this->session->set_flashdata('eror_edit', 'eror_edit');
	            } else {
	                $this->session->set_flashdata('edit', 'edit');
	            }
	            redirect('Cuti/view_pegawai/'.$id_user);
	        } else {
	            // Jika bukan cuti mereka
	            $this->session->set_flashdata('not_allowed', 'not_allowed');
	            redirect('Cuti/view_pegawai/'.$id_user);
	        }
	    } else {
	        // Jika role tidak sesuai
	        $this->session->set_flashdata('not_allowed', 'not_allowed');
	        redirect('Login/index');
	    }
	}

	public function export_excel() {
	    $this->load->model('Cuti_model');
	    $data_cuti = $this->Cuti_model->getAllCuti();

	    // Load PHPExcel
	    $this->load->library('PHPExcel');
	    $excel = new PHPExcel();

	    // Setting Properti File Excel
	    $excel->getProperties()->setCreator('Admin')
	            ->setLastModifiedBy('Admin')
	            ->setTitle('Rekap Data Cuti Pegawai')
	            ->setSubject('Cuti')
	            ->setDescription('Rekap data cuti pegawai');

	    // Membuat Header di Excel
	    $excel->setActiveSheetIndex(0)->setCellValue('A1', 'No');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', 'Nama');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', 'Alasan');
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', 'Tanggal Diajukan');
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', 'Mulai');
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', 'Berakhir');
	    $excel->setActiveSheetIndex(0)->setCellValue('G1', 'Jenis Cuti');
	    $excel->setActiveSheetIndex(0)->setCellValue('H1', 'Status');

	    // Mengisi Data Cuti
	    $row = 2;
	    $no = 1;
	    foreach ($data_cuti as $cuti) {
	        $excel->setActiveSheetIndex(0)->setCellValue('A'.$row, $no);
	        $excel->setActiveSheetIndex(0)->setCellValue('B'.$row, $cuti->nama);
	        $excel->setActiveSheetIndex(0)->setCellValue('C'.$row, $cuti->alasan);
	        $excel->setActiveSheetIndex(0)->setCellValue('D'.$row, $cuti->tgl_diajukan);
	        $excel->setActiveSheetIndex(0)->setCellValue('E'.$row, $cuti->mulai);
	        $excel->setActiveSheetIndex(0)->setCellValue('F'.$row, $cuti->berakhir);
	        $excel->setActiveSheetIndex(0)->setCellValue('G'.$row, $cuti->jenis_cuti);
	        $excel->setActiveSheetIndex(0)->setCellValue('H'.$row, $cuti->status);
	        $row++;
	        $no++;
	    }

	    // Output File Excel
	    $filename = "Rekap_Data_Cuti_Pegawai_".date("Y-m-d").".xls";
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="'.$filename.'"');
	    header('Cache-Control: max-age=0');

	    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	    $writer->save('php://output');
	}

	public function rekap() {
	    $this->load->model('Cuti_model');
	    $data['rekap_cuti'] = $this->Cuti_model->get_rekap_cuti();
	    $this->load->view('admin/view_rekap_cuti', $data);
	}

    public function export_rekap() {
        $this->load->model('Rekap_model');
        $data_rekap = $this->Rekap_model->get_all_rekap();
    }
}