<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
        $this->load->model('m_cuti');
    }

    public function dashboard_pimpinan()
    {
        if ($this->session->userdata('logged_in') == true && in_array($this->session->userdata('id_role'), [3, 4, 5])) {
            $data = [];
		
            // Logika untuk pimpinan1
            if ($this->session->userdata('id_role') == 3) {
                $data['cuti'] = $this->m_cuti->count_all_cuti() ?? 0;
                $data['cuti_acc'] = $this->m_cuti->count_all_cuti_acc() ?? 0;
                $data['cuti_confirm'] = $this->m_cuti->count_all_cuti_confirm() ?? 0;
                $data['cuti_reject'] = $this->m_cuti->count_all_cuti_reject() ?? 0;

                $data['pegawai'] = $this->m_user->count_all_pegawai() ?? 0;
                $data['admin'] = $this->m_user->count_all_admin() ?? 0;
            }

            // Logika untuk pimpinan2
            elseif ($this->session->userdata('id_role') == 4) {
                $data['cuti_confirm'] = $this->m_cuti->count_all_cuti_confirm() ?? 0;
                $data['pegawai'] = $this->m_user->count_all_pegawai() ?? 0;
            }

            // Logika untuk pimpinan3
            elseif ($this->session->userdata('id_role') == 5) {
                $data['cuti_acc'] = $this->m_cuti->count_all_cuti_acc() ?? 0;
                $data['cuti_reject'] = $this->m_cuti->count_all_cuti_reject() ?? 0;
            }

            $this->load->view('pimpinan/dashboard', $data);
        } else {
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    public function dashboard_admin()
    {
        if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 2) {
            $data['cuti'] = $this->m_cuti->count_all_cuti() ?? [];
            $data['cuti_acc'] = $this->m_cuti->count_all_cuti_acc() ?? [];
            $data['cuti_confirm'] = $this->m_cuti->count_all_cuti_confirm() ?? [];
            $data['cuti_reject'] = $this->m_cuti->count_all_cuti_reject() ?? [];
            $data['pegawai'] = $this->m_user->count_all_pegawai() ?? [];

            $this->load->view('admin/dashboard', $data);
        } else {
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }

    public function dashboard_pegawai()
    {
        if ($this->session->userdata('logged_in') == true && $this->session->userdata('id_role') == 1) {
            $id_user = $this->session->userdata('id_user');

            // Mengambil data cuti berdasarkan ID user
            $data['cuti_pegawai'] = $this->m_cuti->get_all_cuti_by_id_user($id_user) ?? [];
            $data['cuti'] = $this->m_cuti->count_all_cuti_by_id($id_user) ?? 0;
            $data['cuti_acc'] = $this->m_cuti->count_all_cuti_acc_by_id($id_user) ?? 0;
            $data['cuti_confirm'] = $this->m_cuti->count_all_cuti_confirm_by_id($id_user) ?? 0;
            $data['cuti_reject'] = $this->m_cuti->count_all_cuti_reject_by_id($id_user) ?? 0;

            // Mengambil data pegawai berdasarkan ID user
            $data['pegawai'] = $this->m_user->get_pegawai_by_id($id_user) ?? [];

            // Mengambil jenis kelamin dari tabel pegawai
            $jenis_kelamin = $this->db->select('jenis_kelamin')
                          ->from('pegawai')
                          ->where('id', $id_user)
                          ->get()
                          ;
            $data['jenis_kelamin'] = $jenis_kelamin['jenis_kelamin'] ?? 'Tidak Diketahui';

            // Memuat view dashboard untuk pegawai
            $this->load->view('pegawai/dashboard', $data);
        } else {
            $this->session->set_flashdata('loggin_err', 'loggin_err');
            redirect('Login/index');
        }
    }
}
