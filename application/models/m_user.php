<?php

class M_user extends CI_Model
{
    public function get_all_roles()
    {
        $this->db->order_by('id_role', 'ASC');
        return $this->db->get('role')->result_array();
    }

    public function get_all_pegawai()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('pegawai', 'users.id = pegawai.id');
        $this->db->where('id_role', 1);
        $this->db->order_by('users.username', 'ASC');
        return $this->db->get()->result_array();
    }

    public function count_all_pegawai()
    {
        $this->db->select('COUNT(id) as total_user');
        $this->db->from('users');
        $this->db->where('id_role', 1);
        $query = $this->db->get();
        
        return $query->row()->total_user;
    }

    public function count_all_admin()
    {
        $this->db->select('COUNT(id) as total_user');
        $this->db->from('users');
        $this->db->where('id_role', 2);
        $query = $this->db->get();
        
        return $query->row()->total_user;
    }

    public function get_all_admin()
    {
        return $this->db->get_where('users', ['id_role' => 2])->result_array();
    }

    public function get_pegawai_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('pegawai', 'users.id = pegawai.id');
        $this->db->where('users.id', $id);
        return $this->db->get()->row_array();
    }

    public function cek_login($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('pegawai', 'users.id = pegawai.id');
        $this->db->where('username', $username);
        return $this->db->get()->row_array();
    }

    public function pendaftaran_user($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
        $this->db->trans_start();

        // Insert ke tabel users
        $data_users = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'id_role' => $id_role
        ];
        $this->db->insert('users', $data_users);

        // Insert ke tabel pegawai
        $data_pegawai = [
            'id_pegawai' => $id,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'no_telp' => $no_telp,
            'alamat' => $alamat
        ];
        $this->db->insert('pegawai', $data_pegawai);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_user_detail($id, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
        $this->db->trans_start();

        // Update data pegawai
        $data_pegawai = [
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'no_telp' => $no_telp,
            'alamat' => $alamat
        ];
        $this->db->where('id_pegawai', $id);
        $this->db->update('pegawai', $data_pegawai);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function insert_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
        $this->db->trans_start();

        // Insert ke tabel users
        $data_users = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'id_role' => $id_role
        ];
        $this->db->insert('users', $data_users);

        // Insert ke tabel pegawai
        $data_pegawai = [
            'id_pegawai' => $id,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'no_telp' => $no_telp,
            'alamat' => $alamat
        ];
        $this->db->insert('pegawai', $data_pegawai);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
        $this->db->trans_start();

        // Update data users
        $data_users = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'id_role' => $id_role
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data_users);

        // Update data pegawai
        $data_pegawai = [
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'no_telp' => $no_telp,
            'alamat' => $alamat
        ];
        $this->db->where('id_pegawai', $id);
        $this->db->update('pegawai', $data_pegawai);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_pegawai($id)
    {
        $this->db->trans_start();

        // Hapus dari tabel users dan pegawai
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->db->where('id_pegawai', $id);
        $this->db->delete('pegawai');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_user($id, $username, $password)
    {
        $this->db->trans_start();

        // Update data users
        $data_users = [
            'username' => $username,
            'password' => $password
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data_users);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
