<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property m_user $m_user
 */

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
	}

	public function view_pimpinan()
	{
	    $this->load->view('pimpinan/settings');
	}

	public function view_admin()
	{
		$this->load->view('admin/settings');
	}

	public function view_pegawai()
	{
		$data['pegawai_data'] = $this->m_user->get_pegawai_by_id($this->session->userdata('id_user'))->result_array();
		$data['pegawai'] = $this->m_user->get_pegawai_by_id($this->session->userdata('id_user'))->row_array();
	}

	public function lengkapi_data()
	{
		$id = $this->input->post("id");
		$nama = $this->input->post("nama");
		$no_telp = $this->input->post("no_telp");
		$alamat = $this->input->post("alamat");
		$jenis_kelamin = $this->input->post("jenis_kelamin");
		$nip = $this->input->post("nip");


		$hasil = $this->m_user->update_user_detail($id, $nama, $jenis_kelamin, $no_telp, $alamat);

        if($hasil==false){
            $this->session->set_flashdata('eror','eror');
            redirect('Settings/view_pegawai');
		}else{
			$this->session->set_flashdata('input','input');
			redirect('Settings/view_pegawai');
		}

	}


	public function settings_account_pimpinan()
	{
	    $id = $this->session->userdata('id_user');
	    $username = $this->input->post("username");
	    $password = $this->input->post("password");
	    $re_password = $this->input->post("re_password");


	    if($password == $re_password)
	    {
	        $hasil = $this->m_user->update_user($id, $username, $password);

	        if($hasil==false){
	            $this->session->set_flashdata('eror_edit','eror_edit');
	            redirect('Settings/view_pimpinan');
	        }else{
	            $this->session->set_flashdata('edit','edit');
	            redirect('Settings/view_pimpinan');
	        }

	    }else{
	        $this->session->set_flashdata('password_err','password_err');
	        redirect('Settings/view_pimpinan');
	    }
	}

	public function settings_account_admin()
	{
		$id = $this->session->userdata('id_user');
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$re_password = $this->input->post("re_password");


		if($password == $re_password)
        {
            $hasil = $this->m_user->update_user($id, $username, $password);

            if($hasil==false){
                $this->session->set_flashdata('eror_edit','eror_edit');
                redirect('Settings/view_admin');
			}else{
				$this->session->set_flashdata('edit','edit');
				redirect('Settings/view_admin');
			}

        }else{
            $this->session->set_flashdata('password_err','password_err');
			redirect('Settings/view_admin');
        }
	}

	public function settings_account_pegawai()
	{
		$id = $this->session->userdata('id_user');
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$re_password = $this->input->post("re_password");


		if($password == $re_password)
        {
            $hasil = $this->m_user->update_user($id, $username, $password);

            if($hasil==false){
                $this->session->set_flashdata('eror_edit','eror_edit');
                redirect('Settings/view_pegawai');
			}else{
				$this->session->set_flashdata('edit','edit');
				redirect('Settings/view_pegawai');
			}

        }else{
            $this->session->set_flashdata('password_err','password_err');
			redirect('Settings/view_pegawai');
        }
	}
}