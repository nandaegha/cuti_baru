<?php

class M_cuti extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    // Metode untuk menyisipkan data cuti
    public function insert_cuti($data) {
        return $this->db->insert('cuti', $data); // 'cuti' adalah nama tabel di database
    }

    // Mendapatkan semua permohonan cuti
    public function get_all_cuti() {
        $this->db->select('cuti.id as id_cuti, cuti.*, users.nama as nama_user, jenis_cuti.nama_jenis_cuti');
        $this->db->from('cuti');
        $this->db->join('users', 'cuti.id_user = users.id');
        $this->db->join('jenis_cuti', 'cuti.id_jenis_cuti = jenis_cuti.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Mendapatkan semua permohonan cuti berdasarkan ID pengguna
    public function get_all_cuti_by_id_user($id_user) {
        $this->db->select('cuti.*, users.nama AS nama_user, jenis_cuti.nama_jenis_cuti, jenis_cuti.id AS id_jenis_cuti'); // Make sure to select id_jenis_cuti
        $this->db->from('cuti');
        $this->db->join('users', 'cuti.id_user = users.id');
        $this->db->join('jenis_cuti', 'cuti.id_jenis_cuti = jenis_cuti.id');
        $this->db->where('cuti.id_user', $id_user);
        $query = $this->db->get();

        return $query->result_array(); // Ensure you return the result as an array
    }

    // Mendapatkan permohonan cuti terbaru yang diterima berdasarkan ID pengguna
    public function get_last_accepted_cuti_by_id_user($id_user) {
        return $this->db->select('*')
                        ->from('cuti')
                        ->where('id_user', $id_user)
                        ->where('status', 2) // Mengganti id_status_cuti menjadi status
                        ->order_by('tgl_diajukan', 'DESC')
                        ->limit(1)
                        ->get()
                        ->row_array();
    }

    // Mendapatkan permohonan cuti berdasarkan ID cuti
    public function get_cuti_by_id($id_cuti) {
        return $this->db->select('*')
                        ->from('cuti')
                        ->where('id_cuti', $id_cuti)
                        ->get()
                        ->row_array();
    }

    // Menyisipkan permohonan cuti baru
    public function insert_data_cuti($id_cuti, $id_user, $alasan, $mulai, $berakhir, $lama_cuti, $status, $jenis_cuti) {
        $data = array(
            'id_cuti' => $id_cuti,
            'id_user' => $id_user,
            'alasan' => $alasan,
            'mulai' => $mulai,
            'berakhir' => $berakhir,
            'lama_cuti' => $lama_cuti,
            'status' => $status,
            'jenis_cuti' => $jenis_cuti,
        );
        
        $this->db->trans_start();
        $this->db->insert('cuti', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Menghapus permohonan cuti
    public function delete_cuti($id_cuti) {
        return $this->db->delete('cuti', array('id' => $id_cuti));
    }

    // Memperbarui permohonan cuti
    public function update_cuti($id_cuti, $data) {
        $this->db->trans_start();
        $this->db->where('id_cuti', $id_cuti);
        $this->db->update('cuti', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Mengkonfirmasi permohonan cuti
    public function confirm_cuti($id_cuti, $status, $alasan_verifikasi) {
        $this->db->trans_start();
        $this->db->where('id_cuti', $id_cuti);
        $this->db->update('cuti', [
            'status' => $status,
            'alasan_verifikasi' => $alasan_verifikasi
        ]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Menghitung total permohonan cuti
    public function count_all_cuti() {
        return $this->db->count_all('cuti');
    }

    // Menghitung total permohonan cuti berdasarkan ID pengguna
    public function count_all_cuti_by_id($id_user) {
        return $this->db->where('id_user', $id_user)
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang diterima
    public function count_all_cuti_acc() {
        return $this->db->where('status', 2) // Mengganti id_status_cuti menjadi status
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang diterima berdasarkan ID pengguna
    public function count_all_cuti_acc_by_id($id_user) {
        return $this->db->where(['status' => 2, 'id_user' => $id_user]) // Mengganti id_status_cuti menjadi status
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang dikonfirmasi
    public function count_all_cuti_confirm() {
        return $this->db->where('status', 1) // Mengganti id_status_cuti menjadi status
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang dikonfirmasi berdasarkan ID pengguna
    public function count_all_cuti_confirm_by_id($id_user) {
        return $this->db->where(['status' => 1, 'id_user' => $id_user]) // Mengganti id_status_cuti menjadi status
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang ditolak
    public function count_all_cuti_reject() {
        return $this->db->where('status', 3)
                        ->from('cuti')
                        ->count_all_results();
    }

    // Menghitung permohonan cuti yang ditolak berdasarkan ID pengguna
    public function count_all_cuti_reject_by_id($id_user) {
        return $this->db->where(['status' => 3, 'id_user' => $id_user]) 
                        ->from('cuti')
                        ->count_all_results();
    }

    // Mendapatkan sisa cuti dari tabel pegawai
    public function get_sisa_cuti($id_user) {
        return $this->db->select('sisa_cuti')
                        ->from('pegawai')
                        ->where('id_user', $id_user)
                        ->get()
                        ->row()->sisa_cuti;
    }

    // Memperbarui sisa cuti setelah cuti diajukan
    public function update_sisa_cuti($id_user, $sisa_cuti_baru) {
        $this->db->trans_start();
        $this->db->where('id_user', $id_user);
        $this->db->update('pegawai', ['sisa_cuti' => $sisa_cuti_baru]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}