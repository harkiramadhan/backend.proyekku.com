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

    function get_byIdTask($idtask){
        $this->db->select('*');
        $this->db->from('task');
        $this->db->where([
            'id' => $idtask
        ]);
        return $this->db->get();
    }

    function get_taskByIdProject($idproject, $idpt){
        $this->db->select('task.*, userpt.name name_user, userpt.username');
        $this->db->from('task');
        $this->db->join('userpt', 'task.pic = userpt.id', 'left');
        $this->db->where([
            'task.idproject' => $idproject,
            'task.idpt' => $idpt
        ]);
        $this->db->order_by('task.actualStart', "ASC");
        return $this->db->get();
    }

    function get_taskByIdProjectDiv($idproject, $idpt, $iddiv){
        $this->db->select('task.*, userpt.name name_user, userpt.username');
        $this->db->from('task');
        $this->db->join('userpt', 'task.pic = userpt.id', 'left');
        $this->db->where([
            'task.idproject' => $idproject,
            'task.idpt' => $idpt,
            'task.iddiv' => $iddiv
        ]);
        $this->db->order_by('task.actualStart', "ASC");
        return $this->db->get();
    }

    function get_taskByIdProjectUser($idproject, $idpt, $iduser){
        $this->db->select('task.*, userpt.name name_user, userpt.username');
        $this->db->from('task');
        $this->db->join('userpt', 'task.pic = userpt.id', 'left');
        $this->db->where([
            'task.idproject' => $idproject,
            'task.idpt' => $idpt,
            'task.pic' => $iduser
        ]);
        $this->db->order_by('task.actualStart', "ASC");
        return $this->db->get();
    }
}