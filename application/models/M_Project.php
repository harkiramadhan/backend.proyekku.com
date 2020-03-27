<?php
class M_Project extends CI_Model{
    function get_byId($idproject){
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where([
            'id' => $idproject
        ]);
        return $this->db->get()->row();
    }

    function get_taskByIdProject($idproject){
        $this->db->select('task.*');
        $this->db->form('task');
        $this->db->where([
            'task.idproject' => $idproject
        ]);
        $this->db->order_by('task.start', "ASC");
        return $this->db->get();
    }
}