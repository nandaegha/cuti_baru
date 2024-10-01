<?php

class Cuti_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function insert_cuti($data) {
        return $this->db->insert('cuti', $data);
    }

    public function get_cuti_data() {
    $this->db->select('cuti.*, users.nama as nama_user, jenis_cuti.nama_cuti as jenis_cuti');
    $this->db->from('cuti');
    $this->db->join('users', 'cuti.id_user = users.id_user');
    $this->db->join('jenis_cuti', 'cuti.id_jenis_cuti = jenis_cuti.id_jenis_cuti');
    $query = $this->db->get();
    }

	public function getAllCuti() {
	    $query = $this->db->get('cuti');  // Ambil semua data dari tabel cuti
	    return $query->result();
	}

}

