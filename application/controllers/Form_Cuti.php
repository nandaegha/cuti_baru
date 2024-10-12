<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property m_user $m_user
 * @property m_cuti $m_cuti
 * @property m_jenis_cuti $m_jenis_cuti
 */

class Form_Cuti extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_cuti');
		$this->load->model('m_user');
		$this->load->model('m_jenis_cuti');
	}

	public function view_pegawai()
	{
		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 1) {

			$data['pegawai_data'] = $this->m_user->get_pegawai_by_id($this->session->userdata('id_user'));
			$data['pegawai'] = $this->m_user->get_pegawai_by_id($this->session->userdata('id_user'));
			$data['jenis_kelamin'] = $data['pegawai']['jenis_kelamin'];  // Mengambil dari tabel pegawai langsung
			$data['jenis_cuti'] = $this->m_jenis_cuti->get_all_jenis_cuti();  // Mengambil data jenis cuti dari tabel jenis_cuti
			$this->load->view('pegawai/form_pengajuan_cuti', $data);

		} else {
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}

	public function proses_cuti()
	{
		if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 1) {

			$id_user = $this->input->post("id_user");
			$alasan = $this->input->post("alasan");
			$jenis_cuti = $this->input->post("jenis_cuti");
		 // $jenis_cuti_str = implode(', ', $jenis_cuti);
			$mulai = $this->input->post("mulai");
			$berakhir = $this->input->post("berakhir");

			// Hitung lama cuti
			$startDate = new DateTime($mulai);
			$endDate = new DateTime($berakhir);
			$interval = $startDate->diff($endDate);
			$lama_cuti = $interval->days + 1;

			// Ambil sisa cuti dari database untuk user
			$sisa_cuti = $this->m_cuti->get_sisa_cuti($id_user);

			// Cek apakah lama cuti lebih besar dari sisa cuti
			if ($lama_cuti > $sisa_cuti) {
				$this->session->set_flashdata('eror_input', 'Cuti melebihi sisa cuti yang tersedia!');
				redirect('Form_Cuti/view_pegawai');
				return;
			}

			$data = array(
				'id_user' => $id_user,
				'alasan' => $alasan,
				'jenis_cuti' => $jenis_cuti,
				'mulai' => $mulai,
				'berakhir' => $berakhir,
				'lama_cuti' => $lama_cuti
			);

			// Gunakan model m_cuti untuk insert data
			if ($this->m_cuti->insert_cuti($data)) {
				$this->session->set_flashdata('input', 'Data Berhasil Ditambahkan!');
				// Update sisa cuti di database
				$sisa_cuti_baru = $sisa_cuti - $lama_cuti;
				$this->m_cuti->update_sisa_cuti($id_user, $sisa_cuti_baru);
			} else {
				$this->session->set_flashdata('eror_input', 'Data Gagal Ditambahkan!');
			}

			$id_cuti = md5($id_user.$alasan.$mulai);
			$status = 1;

			$hasil = $this->m_cuti->insert_data_cuti('cuti-'.substr($id_cuti, 0, 5),$id_user, $alasan, $mulai, $berakhir, $lama_cuti, $status, $jenis_cuti);

			if($hasil == false) {
				$this->session->set_flashdata('eror_input','eror_input');
			} else {
				$this->session->set_flashdata('input','input');
			}

			redirect('Form_Cuti/view_pegawai');

		} else {
			$this->session->set_flashdata('loggin_err','loggin_err');
			redirect('Login/index');
		}
	}
}