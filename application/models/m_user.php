<?php

class M_user extends CI_Model
{

    public function get_all_roles()
    {
        $hasil = $this->db->query("SELECT * FROM role ORDER BY id_role ASC");
        return $hasil;
    }

    public function get_all_pegawai()
    {
        $hasil = $this->db->query('SELECT * FROM users JOIN pegawai ON users.id = pegawai.id
        WHERE id_role = 1 ORDER BY users.username ASC');
        return $hasil;
    }

    public function count_all_pegawai()
    {
        $hasil = $this->db->query('SELECT COUNT(id_user) as total_user FROM users 
        WHERE id_role = 1');
        return $hasil;
    }

    public function count_all_admin()
    {
        $hasil = $this->db->query('SELECT COUNT(id_user) as total_user FROM users WHERE id_role = 2');
        return $hasil;
    }

    public function get_all_admin()
    {
        $hasil = $this->db->query('SELECT * FROM users WHERE id_role = 2');
        return $hasil;
    }

    public function get_pegawai_by_id($id_user)
    {
        $hasil = $this->db->query("SELECT * FROM users JOIN pegawai ON users.id = pegawai.id 
        WHERE users.id='$id_user'");
        return $hasil;
    }

    public function cek_login($username)
    {
        $hasil = $this->db->query("SELECT * FROM users JOIN pegawai ON users.id = pegawai.id 
        WHERE username='$username'");
        return $hasil;
    }

    public function pendaftaran_user($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
       $this->db->trans_start();

       // Insert ke tabel users
       $this->db->query("INSERT INTO users(id_user, username, password, email, id_role) VALUES ('$id', '$username', '$password', '$email', '$id_role')");
       
       // Insert ke tabel pegawai
       $this->db->query("INSERT INTO pegawai(id_pegawai, nama, jenis_kelamin, no_telp, alamat) VALUES ('$id', '$nama', '$jenis_kelamin', '$no_telp', '$alamat')");

       $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

    public function update_user_detail($id, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
       $this->db->trans_start();

       $this->db->query("UPDATE pegawai SET nama='$nama', jenis_kelamin='$jenis_kelamin', no_telp='$no_telp', alamat='$alamat' WHERE id_pegawai='$id'");

       $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

    public function insert_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
       $this->db->trans_start();

       $this->db->query("INSERT INTO users(id_user,username,password,email,id_role) VALUES ('$id','$username','$password','$email','$id_role')");
       $this->db->query("INSERT INTO pegawai(id_pegawai, nama, jenis_kelamin, no_telp, alamat) VALUES ('$id','$nama','$jenis_kelamin','$no_telp','$alamat')");

       $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

    public function update_pegawai($id, $username, $email, $password, $id_role, $nama, $jenis_kelamin, $no_telp, $alamat)
    {
       $this->db->trans_start();

       $this->db->query("UPDATE users SET username='$username', password='$password', email='$email', id_role='$id_role' WHERE id_user='$id'");
       $this->db->query("UPDATE pegawai SET nama='$nama', jenis_kelamin='$jenis_kelamin', no_telp='$no_telp', alamat='$alamat' WHERE id_pegawai='$id'");

       $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

    public function delete_pegawai($id)
    {
        $this->db->trans_start();

        // Hapus dari tabel users dan pegawai
        $this->db->query("DELETE FROM users WHERE id_user='$id'");
        $this->db->query("DELETE FROM pegawai WHERE id_pegawai='$id'");

        $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

    public function update_user($id, $username, $password)
    {
        $this->db->trans_start();

        $this->db->query("UPDATE users SET username='$username', password='$password' WHERE id_user='$id'");

        $this->db->trans_complete();
        if($this->db->trans_status()==true)
            return true;
        else
            return false;
    }

}