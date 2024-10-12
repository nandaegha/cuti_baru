<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // Mengambil data cuti (contoh)
    public function get_data_cuti() {
        return $this->db->get('cuti')->result_array();
    }

    // Mengambil semua rekap cuti
    public function get_all_rekap() {
        $this->db->select('c.*, u.nama as nama_pegawai, j.nama_jenis_cuti as jenis_cuti, c.status as status');
        $this->db->from('cuti c');
        $this->db->join('pegawai p', 'c.id_user = p.id_user');
        $this->db->join('jenis_cuti j', 'c.id_jenis_cuti = j.id_jenis_cuti');
        return $this->db->get()->result_array();
    }
}
