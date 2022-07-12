<?php
//session_start();
class My_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Core_model');
	}

	public function init_vals()
	{
		$data['username'] = $this->session->userdata('uname');
		$data['userid'] = $this->session->userdata('usrid'); 
		$data['userpic'] = $this->session->userdata('clogpic');
		$data['title'] = $this->config->item('title');

		$datacompanyzx = $this->Core_model->load_core_data('company','','',array('code' => $this->session->userdata('comp_id')));

		$data['mycompany'] = $datacompanyzx[0]->name;
		$data['mycompanyid'] = $datacompanyzx[0]->id;

		$roleid = $this->session->userdata('roleid');
		$data['dataaccess'] = $this->Core_model->load_core_data('users_roles',$roleid,'*','','');

		//check role access
		$dataaccess = $this->Core_model->load_core_data('users_roles',$roleid,'*','','');
		$dataroles = json_decode($dataaccess->roles, true);

		foreach($dataroles as $value){

			$ids[] = $value['id'];
			if($value['main_id']!=0){
				$ids[] = $value['main_id'];
			}

		}

		//loading nav menu
		$data['nav_menu'] = $this->Core_model->load_core_data('nav_menu','','*',array('main_id' => NULL),'main ASC,menu_order ASC',array('id' => $ids));
		$data['subnav_menu'] = $this->Core_model->load_core_data('nav_menu','','*','main_id IS NOT NULL','main_id ASC,menu_order ASC',array('id' => $ids));

		return $data;
	}

	public function check_access($idx)
	{
		$roleid = $this->session->userdata('roleid');
		$roleaccess = $this->Core_model->load_core_data('users_roles',$roleid,'*','','');

		$datarolesaccess = json_decode($roleaccess->roles, true);

		$ids = array();
		foreach($datarolesaccess as $value){
			if($value['id']==$idx){
				$ids = $value['access'];
			}   
		}

		return $ids;
	}

	public function denied(){
		$data = $this->init_vals();
		
		$data['loaded_page'] = "denied"; 
		$data['form_name'] = "Access Denied";
	
		$this->load->view('index',$data);
	  }
	

}