<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('login_model');        
    }

    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('login/index',$data);
    }

    public function proses_login(){

		$this->load->model("login_model");
		
		$username=htmlspecialchars($this->input->post('username'));
        $password=htmlspecialchars($this->input->post('password'));
		
		$ceklogin=$this->login_model->login($username, $password);
		if ($ceklogin != false) {
			foreach ($ceklogin as $row) {
				$this->load->library('session');
				$this->session->set_userdata('username', $row->username);
				$this->session->set_userdata('id_user', $row->id_user );
				$this->session->set_userdata('level', $row->level);
				$this->session->set_userdata('nama', $row->nama );
				
				if($this->session->userdata('level')=='admin'){
					redirect('Admin/admin');
				}
				else if($this->session->userdata('level')=='member'){
						redirect('member/member');
                    }
            }
		}else{
				$data['title'] = 'Login';
				$this->load->view('login/index');
				$this->session->set_flashdata('pesan','Username dan Password Anda salah');
				redirect('Admin/login');
			}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('Admin/login', 'refresh');
	}
	
}
/* End of file Controllername.php */
?>