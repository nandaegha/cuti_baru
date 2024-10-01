<?php

class M_jenis_cuti extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    // Mendapatkan semua jenis cuti dari tabel 'jenis_cuti'
    public function get_all_jenis_cuti() {
        return $this->db->select('*')
                        ->from('jenis_cuti')
                        ->order_by('nama_jenis_cuti', 'ASC')
                        ->get()
                        ->result_array();
    }

    // Mendapatkan jenis cuti berdasarkan ID
    public function get_jenis_cuti_by_id($id_jenis_cuti) {
        return $this->db->select('*')
                        ->from('jenis_cuti')
                        ->where('id_jenis_cuti', $id_jenis_cuti)
                        ->get()
                        ->row_array();
    }

    // Menambahkan jenis cuti baru
    public function insert_jenis_cuti($data) {
        $this->db->trans_start();
        $this->db->insert('jenis_cuti', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Memperbarui jenis cuti berdasarkan ID
    public function update_jenis_cuti($id_jenis_cuti, $data) {
        $this->db->trans_start();
        $this->db->where('id_jenis_cuti', $id_jenis_cuti);
        $this->db->update('jenis_cuti', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Menghapus jenis cuti berdasarkan ID
    public function delete_jenis_cuti($id_jenis_cuti) {
        $this->db->trans_start();
        $this->db->delete('jenis_cuti', ['id_jenis_cuti' => $id_jenis_cuti]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}