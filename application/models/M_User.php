<?php
class M_User extends CI_Model{
    
    function get_allUser(){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->where([
            'status !=' => "soft_delete"
        ]);
        $this->db->order_by('user.idrole', "ASC");
        $this->db->order_by('user.username', "ASC");
        return $this->db->get();
    }

    function get_userPending(){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->where([
            'status' => "pending"
        ]);
        $this->db->order_by('user.idrole', "ASC");
        $this->db->order_by('user.username', "ASC");
        return $this->db->get();
    }
}