<?php
class M_Auth extends CI_Model{
    function get_allUser(){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->order_by('user.username', "ASC");
        return $this->db->get();
    }

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
}