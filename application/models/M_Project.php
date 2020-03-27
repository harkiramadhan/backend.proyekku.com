<?php
class M_Project extends CI_Model{
    function get_byId($idproject){
        $this->db->select('project.*, division.division');
        $this->db->from('project');
        $this->db->join('division', 'project.iddiv = division.id');
        $this->db->where([
            'project.id' => $idproject
        ]);
        return $this->db->get()->row();
    }

    function get_taskByIdProject($idproject, $idpt){
        $this->db->select('task.*, userpt.name, userpt.username');
        $this->db->from('task');
        $this->db->join('userpt', 'task.pic = userpt.id');
        $this->db->where([
            'task.idproject' => $idproject,
            'task.idpt' => $idpt
        ]);
        $this->db->order_by('task.start', "ASC");
        return $this->db->get();
    }
}