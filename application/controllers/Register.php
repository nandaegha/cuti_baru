<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property m_user $m_user
 */

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user'); // Model untuk tabel users dan pegawai
    }

    public function index()
    {
        $this->load->view('register');
    }

    public function proses()
    {
        // Mengambil data dari form register
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        $re_password = $this->input->post("re_password");
        $nama = $this->input->post("nama"); // Mengganti nama_lengkap dengan nama
        $jenis_kelamin = $this->input->post("jenis_kelamin"); // Diambil dari form pendaftaran
        $no_telp = $this->input->post("no_telp");
        $alamat = $this->input->post("alamat");

        $id_role = 1; // Default: Pegawai biasa
        $id = md5($username.$email.$password); // Membuat ID user unik

        // Validasi apakah password sama dengan re_password
        if ($password == $re_password) {
            // Simpan ke tabel users dan pegawai
            $hasil = $this->m_user->pendaftaran_user($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat);

            if ($hasil == false) {
                // Jika terjadi error saat pendaftaran, beri flashdata dan redirect ke halaman register
                $this->session->set_flashdata('eror', 'Terjadi kesalahan, coba lagi.');
                redirect('register/index');
            } else {
                // Jika berhasil, beri flashdata dan redirect ke halaman login
                $this->session->set_flashdata('input', 'Registrasi berhasil.');
                redirect('login/index');
            }
        } else {
            // Jika password dan re_password tidak sesuai, beri flashdata error
            $this->session->set_flashdata('password_err', 'Password tidak sesuai.');
            redirect('register/index');
        }
    }
}