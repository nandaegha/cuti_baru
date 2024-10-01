<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
        $this->load->model('m_jenis_cuti'); 
    }

    public function view_pimpinan()
    {
        if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 3) { 
            $data['admin_data'] = $this->m_user->get_all_admin()->result_array();
            $this->load->view('pimpinan/admin', $data); 

        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    public function tambah_admin()
    {
        if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 3) { 
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $email = $this->input->post("email");
            $id_role = 2;
            $id = md5($username . $email . $password);

            $hasil = $this->m_user->pendaftaran_user($id, $username, $email, $password, $id_role);

            if ($hasil == false) {
                $this->session->set_flashdata('eror', 'eror');
                redirect('Admin/view_pimpinan'); 
            } else {
                $this->session->set_flashdata('input', 'input');
                redirect('Admin/view_pimpinan'); 
            }

        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    public function edit_admin()
    {
        if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 3) { 

            $id_user = $this->input->post("id_user");
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $email = $this->input->post("email");
            $id_role = 2; 

            $hasil = $this->m_user->update_user($id_user, $username, $email, $password, $id_role);

            if ($hasil == false) {
                $this->session->set_flashdata('eror_edit', 'eror_edit');
                redirect('Admin/view_pimpinan');
            } else {
                $this->session->set_flashdata('edit', 'edit');
                redirect('Admin/view_pimpinan');
            }

        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    public function hapus_admin()
    {
        if ($this->session->userdata('logged_in') == true AND $this->session->userdata('id_role') == 3) {
            $id_user = $this->input->post("id_user");

            $hasil = $this->m_user->delete_admin($id_user);

            if ($hasil == false) {
                $this->session->set_flashdata('eror_hapus', 'eror_hapus');
                redirect('Admin/view_pimpinan');
            } else {
                $this->session->set_flashdata('hapus', 'hapus');
                redirect('Admin/view_pimpinan');
            }

        } else {

            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    // Menampilkan halaman pengelolaan jenis cuti
    public function jenis_cuti() {
        $data['jenis_cuti'] = $this->m_jenis_cuti->get_all_jenis_cuti(); // Ambil data jenis cuti
        $this->load->view('admin/jenis_cuti', $data);
    }

    // Tambah jenis cuti baru
    public function tambah_jenis_cuti() {
        // Proses untuk tambah jenis cuti
        $jenis_cuti = $this->input->post('jenis_cuti');
        $data = array(
            'nama_jenis_cuti' => $jenis_cuti
        );
        $this->m_jenis_cuti->insert_jenis_cuti($data);
        redirect('Admin_Cuti/jenis_cuti');
    }

    // Hapus jenis cuti
    public function hapus_jenis_cuti($id) {
        $this->m_jenis_cuti->delete_jenis_cuti($id);
        redirect('Admin_Cuti/jenis_cuti');
    }
}