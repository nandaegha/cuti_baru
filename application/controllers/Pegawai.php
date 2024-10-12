<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property m_user $m_user
 */

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
	}

    // View untuk pimpinan
    public function view_pimpinan()
	{
		if ($this->session->userdata('logged_in') == true &&
		    in_array($this->session->userdata('id_role'), [3, 4, 5])) {

			$data['pegawai'] = $this->m_user->get_all_pegawai()->result_array();
			$this->load->view('pimpinan/pegawai', $data);

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // View untuk admin
	public function view_admin()
	{
		if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 2) { // Admin

			$data['pegawai'] = $this->m_user->get_all_pegawai()->result_array();
			$this->load->view('admin/pegawai', $data);

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi tambah pegawai untuk admin
	public function tambah_pegawai()
	{
		if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 2) {

			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$email = $this->input->post("email");
			$nama = $this->input->post("nama");
			$jenis_kelamin = $this->input->post("jenis_kelamin");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$id_role = 1; // Pegawai biasa
			$id = md5($username.$email.$password);

			$hasil = $this->m_user->insert_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat);

			if($hasil == false){
				$this->session->set_flashdata('eror', 'eror');
				redirect('Pegawai/view_admin');
			} else {
				$this->session->set_flashdata('input', 'input');
				redirect('Pegawai/view_admin');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi edit pegawai untuk admin
	public function edit_pegawai()
	{
		if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 2) {

			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$email = $this->input->post("email");
			$nama = $this->input->post("nama");
			$jenis_kelamin = $this->input->post("jenis_kelamin");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$id_role = 1;
			$id = $this->input->post("id_user");

			$hasil = $this->m_user->update_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat);

			if($hasil == false){
				$this->session->set_flashdata('eror_edit', 'eror_edit');
				redirect('Pegawai/view_admin');
			} else {
				$this->session->set_flashdata('edit', 'edit');
				redirect('Pegawai/view_admin');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi hapus pegawai untuk admin
	public function hapus_pegawai()
	{
		if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 2) {

			$id = $this->input->post("id_user");

			$hasil = $this->m_user->delete_pegawai($id);

			if($hasil == false){
				$this->session->set_flashdata('eror_hapus', 'eror_hapus');
				redirect('Pegawai/view_admin');
			} else {
				$this->session->set_flashdata('hapus', 'hapus');
				redirect('Pegawai/view_admin');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi tambah pegawai untuk pimpinan
	public function pimpinan_tambah_pegawai()
	{
		if ($this->session->userdata('logged_in') == true && 
		    in_array($this->session->userdata('id_role'), [3, 4, 5])) {

			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$email = $this->input->post("email");
			$nama = $this->input->post("nama");
			$jenis_kelamin = $this->input->post("jenis_kelamin");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$id_role = 1; // Pegawai biasa
			$id = md5($username.$email.$password);

			$hasil = $this->m_user->insert_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat);

			if($hasil == false){
				$this->session->set_flashdata('eror', 'eror');
				redirect('Pegawai/view_pimpinan');
			} else {
				$this->session->set_flashdata('input', 'input');
				redirect('Pegawai/view_pimpinan');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi edit pegawai untuk pimpinan
	public function pimpinan_edit_pegawai()
	{
		if ($this->session->userdata('logged_in') == true &&
		    in_array($this->session->userdata('id_role'), [3, 4, 5])) {

			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$email = $this->input->post("email");
			$nama = $this->input->post("nama");
			$jenis_kelamin = $this->input->post("jenis_kelamin");
			$no_telp = $this->input->post("no_telp");
			$alamat = $this->input->post("alamat");
			$id_role = 1; // Pegawai biasa
			$id = $this->input->post("id_user");

			$hasil = $this->m_user->update_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat);

			if($hasil == false){
				$this->session->set_flashdata('eror_edit', 'eror_edit');
				redirect('Pegawai/view_pimpinan');
			} else {
				$this->session->set_flashdata('edit', 'edit');
				redirect('Pegawai/view_pimpinan');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}

    // Fungsi hapus pegawai untuk pimpinan
	public function pimpinan_hapus_pegawai()
	{
		if ($this->session->userdata('logged_in') == true &&
		    in_array($this->session->userdata('id_role'), [3, 4, 5])) {

			$id = $this->input->post("id_user");

			$hasil = $this->m_user->delete_pegawai($id);

			if($hasil == false){
				$this->session->set_flashdata('eror_hapus', 'eror_hapus');
				redirect('Pegawai/view_pimpinan');
			} else {
				$this->session->set_flashdata('hapus', 'hapus');
				redirect('Pegawai/view_pimpinan');
			}

		} else {
			$this->session->set_flashdata('loggin_err', 'loggin_err');
			redirect('Login/index');
		}
	}
}