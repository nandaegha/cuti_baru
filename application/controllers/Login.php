<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function proses()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $user = $this->m_user->cek_login($username);

        if($user->num_rows()>0){
            $user = $user->row_array();

            if($user['password'] == $password){

                // Set session data umum
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('id_user', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('nama', $user['nama']);
                $this->session->set_userdata('id_role', $user['id_role']); // Menyesuaikan dengan role

                // Kondisi untuk pegawai
                if($user['id_role'] == 1){ // Pegawai
                    $this->session->set_flashdata('success_login','success_login');
                    redirect('Dashboard/dashboard_pegawai');

                // Kondisi untuk admin
                } else if($user['id_role'] == 2){ // Admin
                    $this->session->set_flashdata('success_login','success_login');
                    redirect('Dashboard/dashboard_admin');

                // Kondisi untuk pimpinan (pimpinan1, pimpinan2, pimpinan3)
                } else if($user['id_role'] == 3 || $user['id_role'] == 4 || $user['id_role'] == 5){ // Pimpinan
                    $this->session->set_flashdata('success_login','success_login');
                    redirect('Dashboard/dashboard_pimpinan');

                } else {
                    // Jika role tidak dikenali
                    $this->session->set_flashdata('loggin_err','loggin_err');
                    redirect('Login/index');
                }

            } else {
                // Password salah
                $this->session->set_flashdata('loggin_err_pass','loggin_err_pass');
                redirect('Login/index');
            }
        } else {
            // Username tidak ditemukan
            $this->session->set_flashdata('loggin_err_no_user','loggin_err_no_user');
            redirect('Login/index');
        }
    }

    public function log_out(){
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('id_user');
        $this->session->set_flashdata('success_log_out','success_log_out');
        redirect('Login/index');
    }
}