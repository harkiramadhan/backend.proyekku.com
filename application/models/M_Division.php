<?php
class M_Division extends CI_Model{

    function get_all($idpt){
        $this->db->select('*');
        $this->db->from('division');
        $this->db->where([
            'idpt' => $idpt,
            'status !=' => "soft_delete"
        ]);
        $this->db->order_by('division', "ASC");
        return $this->db->get();
    }

    function get_division($iduser){
        $this->db->select('division.division');
        $this->db->from('userpt');
        $this->db->join('division', 'userpt.iddiv = division.id');
        $this->db->where([
            'userpt.id' => $iduser
        ]);
        return $this->db->get()->row();
    }
}