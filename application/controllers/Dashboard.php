<?php
class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->model('M_User');
        if($this->session->userdata('masuk') != TRUE){
            $url = base_url();
            redirect($url,'refresh');
        }
    }

    function session($sess){
        $get = $this->session->userdata($sess);
        return $get;
    }

    function index(){
        $role = $this->session->userdata('role');

        $var['title'] = "Dashboard";
        $var['username'] = $this->session('username');
        $var['role'] = $this->db->get_where('role', ['id' => $role])->row()->role;

        $data = [];
        $comp = [];
        $del = [];
        $tot = [];
        $miss = [];
        $perc = [];

        if($role == 1){
            $var['user'] = $this->M_User->get_allUser()->num_rows();
            $var['userPending'] = $this->M_User->get_userPending()->num_rows();

            $this->load->view('admin_super/layout/header', $var);
            $this->load->view('admin_super/dashboard', $var);
            $this->load->view('admin_super/layout/footer', $var);           
        }elseif($role == 2){
            $iduser = $this->session('iduser');
            $var['user'] = $this->M_User->get_allUserPT($iduser)->num_rows();

            $var['totalProject'] = $this->db->get_where('project', ['idpt' => $iduser])->num_rows();
            $var['totalTask'] = $this->db->get_where('task', ['idpt' => $iduser])->num_rows();
            $var['taskComplete'] = $this->db->get_where('task', ['idpt' => $iduser, 'status' => "Done"])->num_rows();
            $var['userPending'] = $this->M_User->get_userPtPending($iduser)->num_rows();
            $var['totalProject'] = $this->db->order_by('id', "ASC")->get_where('project', ['idpt' => $iduser]);

            foreach($var['totalProject']->result() as $p){
                $data[] = $p->project_name;
                $tasks = $this->db->get_where('task', ['idproject' => $p->id]);
                $comp[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue' => "100%"])->num_rows();
                $del[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%", 'status' => 'Pending'])->num_rows();
                $tot[] = $tasks->num_rows();

                $a = [];
                $n = 1;
                $cek = $this->db->select('timestamp, actualEnd')->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%"])->result();
                foreach($cek as $c){
                    if(date('Y-m-d', strtotime($c->timestamp)) > date('Y-m-d', strtotime($c->actualEnd))){
                        array_push($a, $n++);
                    }
                }

                $miss[] = count($a); 

                $jumtas = $tasks->num_rows();

                if($jumtas > 0){
                    $this->db->select_sum('progressValue');
                    $this->db->where('idproject', $p->id);
                    $sum = $this->db->get('task');
                    $perc[] = substr($sum->row()->progressValue / $jumtas, 0, 4); 
                }
            }

            $var['project'] = json_encode($data);
            $var['compl'] = json_encode($comp);
            $var['del'] = json_encode($del);
            $var['tot'] = json_encode($tot);
            $var['miss'] = json_encode($miss);
            $var['perc'] = json_encode($perc);

            $this->load->view('admin_pt/layout/header', $var);
            $this->load->view('admin_pt/dashboard', $var);
            $this->load->view('admin_pt/layout/footer', $var);   
        }elseif($role == 3){
            $iduser = $this->session('iduser');
            $iddiv = $this->session('iddiv');
            $var['user'] = $this->M_User->get_allUserDiv($iddiv)->num_rows();
            $var['userPending'] = $this->M_User->get_userDivPending($iddiv)->num_rows();
            $var['totalProject'] = $this->db->order_by('id', "ASC")->get_where('project', ['iddiv' => $iddiv]);
            
            foreach($var['totalProject']->result() as $p){
                $data[] = $p->project_name;
                $tasks = $this->db->get_where('task', ['idproject' => $p->id]);
                $comp[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue' => "100%"])->num_rows();
                $del[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%", 'status' => 'Pending'])->num_rows();
                $tot[] = $tasks->num_rows();
                
                $a = [];
                $n = 1;
                $cek = $this->db->select('timestamp, actualEnd')->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%"])->result();
                foreach($cek as $c){
                    if(date('Y-m-d', strtotime($c->timestamp)) > date('Y-m-d', strtotime($c->actualEnd))){
                        array_push($a, $n++);
                    }
                }

                $miss[] = count($a); 

                $jumtas = $tasks->num_rows();

                if($jumtas > 0){
                    $this->db->select_sum('progressValue');
                    $this->db->where('idproject', $p->id);
                    $sum = $this->db->get('task');
                    $perc[] = substr($sum->row()->progressValue / $jumtas, 0, 4); 
                }
            }

            $var['project'] = json_encode($data);
            $var['compl'] = json_encode($comp);
            $var['del'] = json_encode($del);
            $var['tot'] = json_encode($tot);
            $var['miss'] = json_encode($miss);
            $var['perc'] = json_encode($perc);

            $this->load->view('admin_div/layout/header', $var);
            $this->load->view('admin_div/dashboard', $var);
            $this->load->view('admin_div/layout/footer', $var);   
        }elseif($role == 4){
            $iduser = $this->session('iduser');
            $iddiv = $this->session('iddiv');

            $var['totalProject'] = $this->db->get_where('project', ['iddiv' => $iddiv])->num_rows();
            $var['totalTask'] = $this->db->get_where('task', ['iddiv' => $iddiv])->num_rows();
            $var['totalProject'] = $this->db->order_by('id', "ASC")->get_where('project', ['iddiv' => $iddiv]);

            foreach($var['totalProject']->result() as $p){
                $data[] = $p->project_name;
                $tasks = $this->db->get_where('task', ['idproject' => $p->id]);
                $comp[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue' => "100%"])->num_rows();
                $del[] = $this->db->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%", 'status' => 'Pending'])->num_rows();
                $tot[] = $tasks->num_rows();
                
                $a = [];
                $n = 1;
                $cek = $this->db->select('timestamp, actualEnd')->get_where('task', ['idproject' => $p->id, 'progressValue !=' => "100%"])->result();
                foreach($cek as $c){
                    if(date('Y-m-d', strtotime($c->timestamp)) > date('Y-m-d', strtotime($c->actualEnd))){
                        array_push($a, $n++);
                    }
                }

                $miss[] = count($a); 

                $jumtas = $tasks->num_rows();

                if($jumtas > 0){
                    $this->db->select_sum('progressValue');
                    $this->db->where('idproject', $p->id);
                    $sum = $this->db->get('task');
                    $perc[] = substr($sum->row()->progressValue / $jumtas, 0, 4); 
                }
            }

            $var['project'] = json_encode($data);
            $var['compl'] = json_encode($comp);
            $var['del'] = json_encode($del);
            $var['tot'] = json_encode($tot);
            $var['miss'] = json_encode($miss);
            $var['perc'] = json_encode($perc);

            $this->load->view('user/layout/header', $var);
            $this->load->view('user/dashboard', $var);
            $this->load->view('user/layout/footer', $var);   
        }
    }
}