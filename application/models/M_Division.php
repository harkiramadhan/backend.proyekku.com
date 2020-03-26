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
}