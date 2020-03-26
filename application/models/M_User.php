<?php
class M_User extends CI_Model{
    
    function get_allUser(){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->where([
            'user.status !=' => "soft_delete"
        ]);
        $this->db->order_by('user.idrole', "ASC");
        $this->db->order_by('user.name', "ASC");
        return $this->db->get();
    }

    function get_allUserPT($idpt){
        $this->db->select('userpt.*, role.role, division.division');
        $this->db->from('userpt');
        $this->db->join('role', 'userpt.idrole = role.id');
        $this->db->join('division', 'userpt.iddiv = division.id');
        $this->db->where([
            'userpt.status !=' => 'soft_delete',
            'userpt.idpt' => $idpt
        ]);
        $this->db->order_by('userpt.name', "ASC");
        return $this->db->get();
    }

    function get_allUserDiv($iddiv){
        $this->db->select('userpt.*, role.role, division.division');
        $this->db->from('userpt');
        $this->db->join('role', 'userpt.idrole = role.id');
        $this->db->join('division', 'userpt.iddiv = division.id');
        $this->db->where([
            'userpt.status !=' => 'soft_delete',
            'userpt.iddiv' => $iddiv,
            'userpt.idrole !=' => 3
        ]);
        $this->db->order_by('userpt.name', "ASC");
        return $this->db->get();
    }

    function get_userDivPending($iddiv){
        $this->db->select('userpt.*, role.role, division.division');
        $this->db->from('userpt');
        $this->db->join('role', 'userpt.idrole = role.id');
        $this->db->join('division', 'userpt.iddiv = division.id');
        $this->db->where([
            'userpt.status' => 'pending',
            'userpt.iddiv' => $iddiv,
            'userpt.idrole !=' => 3
        ]);
        $this->db->order_by('userpt.name', "ASC");
        return $this->db->get();
    }

    function get_userPending(){
        $this->db->select('user.*, role.role');
        $this->db->from('user');
        $this->db->join('role', "user.idrole = role.id");
        $this->db->where([
            'user.status' => "pending"
        ]);
        $this->db->order_by('user.idrole', "ASC");
        $this->db->order_by('user.username', "ASC");
        return $this->db->get();
    }
}