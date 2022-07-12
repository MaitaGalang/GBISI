<?php

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','html'));
		$this->load->library(array('session'));
		$this->load->database();
	}

    public function index()
    {

		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('uname');
		$this->session->unset_userdata('usrid');
		$this->session->unset_userdata('cstatus');
		$this->session->unset_userdata('clogpic');
		$this->session->unset_userdata('roleid');
		$this->session->unset_userdata('usridval'); 
		$this->session->unset_userdata('comp_id');
		$this->session->sess_destroy();
		//$data = array('title' => $this->config->item('title'));
		//$this->load->view('login',$data);
		redirect('/Login');
    }
	
}

?>