<?php
class M_Auth extends CI_Model{

    function userLogin($username, $password){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->where([
            'user.username' => $username,
            'user.password' => md5($password)
        ]);
        return $this->db->get();
    }

    function cek_user($username){
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where([
            'username' => $username
        ]);
        return $this->db->get();
    }
}