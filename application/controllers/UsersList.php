<?php

class UsersList extends CI_Controller {

   public function __construct()
   {
	parent::__construct();
	$this->load->helper(array('form','url','html','string'));
	$this->load->library(array('session', 'form_validation'));
	$this->load->database();
	$this->load->model('Admin_model');
	$this->load->model('Settings_model');				
	$this->load->model('Mycrud');
   }

   public function index() {

			$data['username'] = $this->session->userdata('uname');
			$data['userid'] = $this->session->userdata('usrid'); 
			$data['userpic'] = $this->session->userdata('clogpic');
			$data['userole'] = $this->session->userdata('userrole');
			$data['title'] = $this->config->item('title');

		  	$sess_logged = $this->session->userdata('login');
			$sess_usertype = $this->session->userdata('usertyp');
  
		   if($sess_logged!=TRUE)
		  {			
					$this->failed();
			  
		  }else{

				if($sess_usertype!='Agent'){
					$this->wrongaccess();
				}else{
					//get disitnct area names
					$query = "Select id, plantdeptname From plantdept Where id IS NOT NULL Order By plantdeptname";
					$statement = $this->db->query($query);
					$data['ares'] = $statement->result_array();
					
					$query = "Select DISTINCT type From users Where type IS NOT NULL Order By type";
					$statement = $this->db->query($query);
					$data['usrtyp'] = $statement->result_array();
					
					$this->load->view('settings/UsersList', $data);
				}
				
		 }
	
   }

		public function failed(){
			$data = array('title' => $this->config->item('title'));
			$this->load->view('failed',$data);
		}

		public function wrongaccess(){
			$data = array('title' => $this->config->item('title'));
			redirect("Frontend");
		}
		
		public function relog(){
			redirect('login');
		}
   
   public function posts(){
	
				$column = array('1', 'A.fullname', 'A.cemailadd', 'A.department');

				$query = "SELECT A.Userid, A.fullname, A.cemailadd, A.department, A.cstatus, A.deptid FROM users as A Where Userid IS NOT NULL";
				$where = "";

				if(isset($_POST['tname']) && $_POST['tname'] != '')
				{

						$where .= ' AND A.fullname like \'%'.strtoupper($_POST['tname']).'%\'';

				 		
				}
				
				if(isset($_POST['tplantdept']) && $_POST['tplantdept'] != '') 
				{

						$where .= ' AND A.deptid = '.$_POST['tplantdept'];

				 		
				}
				
				if(isset($_POST['tusrtyp']) && $_POST['tusrtyp'] != '')
				{

						$where .= ' AND UPPER(A.type) = \''.strtoupper($_POST['tusrtyp']).'\'';

				 		
				}

				$query .= $where;
//echo $query ;
				if(isset($_POST['order']))
				{
				 $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
				}
				else
				{
				 $query .= ' ORDER BY A.Userid ASC ';
				}

				$query1 = ' LIMIT 0,10';

				if(isset($_POST["length"])){
					if($_POST["length"] != -1)
					{
					 $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
					}
				}

				$statement = $this->db->query($query);

				$number_filter_row = $statement->num_rows();

				$statement = $this->db->query($query.$query1);

				$data = array();

				foreach($statement->result_array() as $row)
				{
					
				 $sub_array = array();
				 $sub_array[] = $row['Userid'];
				 $sub_array[] = $row['fullname'];
				 $sub_array[] = $row['cemailadd'];
				 $sub_array[] = $row['department'];
				 $sub_array[] = $row['cstatus'];
				 $sub_array[] = $row['deptid'];
				 $data[] = $sub_array;
				}

				$output = array(
				 "draw" => intval($_POST["draw"]),
				 "recordsTotal" => $this->count_all_data(),
				 "recordsFiltered" => $number_filter_row,
				 "data" => $data
				);

				echo json_encode($output);

    }
	
    public function count_all_data()
		{
				 $query = "SELECT * FROM users";
				 $statement =  $this->db->query($query);
				 return $statement->num_rows();
		}
	
    public function totalItems()
    {

        $query = $this->db->query("Select COUNT(*) as num FROM users");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }	
	
	public function createnew(){
			$data['username'] = $this->session->userdata('uname');
			$data['userid'] = $this->session->userdata('usrid'); 
			$data['userpic'] = $this->session->userdata('clogpic');
			$data['userole'] = $this->session->userdata('userrole');
			$data['title'] = $this->config->item('title');

		 // $sess_logged = $this->session->userdata('login');
		 $sess_logged = TRUE;
		//	$sess_usertype = $this->session->userdata('usertyp');
		$sess_usertype ='Agent';
  		$txtUserID = $this->session->userdata('usrid');

		  if($sess_logged!=TRUE)
		  {			
					$this->failed();
			  
		  }else{

				if($sess_usertype!='Agent'){
					$this->wrongaccess();
				}else{

						$query = "Select id, plantdeptname, locationid From plantdept Where id IS NOT NULL Order By plantdeptname";
						$statement = $this->db->query($query);
						$data['ares'] = $statement->result_array(); 
						
						$query2 = "Select deptid, deptname From servicingdept Where linactive=false";
						$statement2 = $this->db->query($query2);
						$data['servdept'] = $statement2->result_array(); 

						$query3 = "Select DISTINCT A.Userid, B.fullname From users_agents A left join users B on A.Userid=B.Userid Where A.role='DeptHead'";
						$statement3 = $this->db->query($query3);
						$data['apprs'] = $statement3->result_array();

						$query4 = "Select DISTINCT A.id, A.name, A.cdesc From clusters A where A.linactive=false Order by A.name";
						$statement4 = $this->db->query($query4);
						$data['clustrs'] = $statement4->result_array();

						$this->load->view('settings/Users_New', $data);

				}
				
		 }
	}

	public function save_newcust(){
						$txtUserID = $this->session->userdata('usrid');

						$usrtype = $this->input->post("selusrtype");
						$usrid = $this->input->post("txtUserID");
						$usremail = $this->input->post("txtcEmail"); 
						$usrdeptid = $this->input->post("selplantdept");
						$usrdept = $this->input->post("selplantdeptname"); 
						$usrlocation = $this->input->post("sellocid");
						$password = "Password";

						if($this->input->post("selnmetyp")==1){
							$usrfname = strtoupper($this->input->post("txtFName"));
							$usrmi = strtoupper($this->input->post("txtMI"));
							$usrlname = strtoupper($this->input->post("txtLName"));
							$fullname = strtoupper($usrfname)." ".strtoupper($usrmi)." ".strtoupper($usrlname);
						
							$data_to_store = array(
							'Userid' => $usrid,
							'Fname' => $usrfname,
							'Lname' => $usrlname,
							'Minit' => $usrmi,
							'password' => $password,
							'cemailadd' => $usremail,
							'cstatus'	 => "Active",
							'fullname' => $fullname,
							'type' => $usrtype,
							'department' => $usrdept,
							'locationid' => $usrlocation,
							'deptid' => $usrdeptid
						);

						}else{
							$fullname = strtoupper($this->input->post("txtFullName"));

							$data_to_store = array(
							'Userid' => $usrid,
							'password' => $password,
							'cemailadd' => $usremail,
							'cstatus'	 => "Active",
							'fullname' => $fullname,
							'type' => $usrtype,
							'department' => $usrdept,
							'locationid' => $usrlocation,
							'deptid' => $usrdeptid
						);
						}
						//$query = $this->db->query("UPDATE users set password=crypt('$password',gen_salt('bf', 8)), updated_at='$dte' where Userid='$uid'");

						if($this->Mycrud->insert('users',$data_to_store)){
							//updatepassword
							$pwrd = getHashedPassword('Password');
							$this->db->query("UPDATE users set password='".$pwrd."' Where Userid = '$usrid'");
							$ip = $this->input->ip_address();

							//insert addtionals for AGENTS
							if($usrtype=="Agent"){
								
								//users_agents table
								$agentservdept = $this->input->post("selservdept");
								$agentappr = $this->input->post("sellapprid");
								$agentrole = $this->input->post("selagentrole");
								$data_agents = array('Userid' => $usrid, 'servicingdeptid' => $agentservdept,'approvaluser' =>	$agentappr,'role' => $agentrole);
								$this->Mycrud->insert('users_agents',$data_agents);

								//users_clusters table
								$dataclusters = $this->input->post('chkClustrs');
								foreach($dataclusters as $clusval){
									$data_clusters = array('Userid' => $usrid, 'clusterid' => $clusval,'linactive' =>	false);
									$this->Mycrud->insert('users_clusters',$data_clusters);
								}
							} 

							if($usrtype=="Owners"){
								
								$selownerstables = $this->input->post("ownerspldtnme");
								foreach ($selownerstables as $valuesdcfg) {
									$splitxvald = explode(":",$valuesdcfg);
									$this->Mycrud->insert('users_owners',array('Userid' => $usrid, 'plantdeptid' => $splitxvald[0], 'plantdeptname' => $splitxvald[1]));
								}

							}

							//Insert Logfile
							$data2 = array(
								'transid' => 1,
								'ticketid' => $usrid,
								'ddate' => date("Y-m-d H:i:s"),
								'cevent' => "INSERTED",
								'cuser' => $txtUserID,
								'cmodule' => "USERS",
								'cmachine' => $ip,
								'cdescription' => "Inserted New User"
							);
							$this->Mycrud->insert('logfile',$data2);

							echo "True";
							
						}else{
							echo "False";
						}

	}

	public function user_details(){
			$data['username'] = $this->session->userdata('uname');
			$data['userid'] = $this->session->userdata('usrid'); 
			$data['userpic'] = $this->session->userdata('clogpic');
			$data['userole'] = $this->session->userdata('userrole');
			$data['title'] = $this->config->item('title');

		  $sess_logged = $this->session->userdata('login');
			$sess_usertype = $this->session->userdata('usertyp');
  		$txtUserID = $this->session->userdata('usrid');

		  if($sess_logged!=TRUE)
		  {			
					$this->failed();
			  
		  }else{

				if($sess_usertype!='Agent'){
					$this->wrongaccess();
				}else{

						$usid = $this->input->post("cusid");

						$qry = "Select * From users Where Userid = '$usid'";
						$state = $this->db->query($qry);
						$data['usrdets'] = $state->result_array();
						$staterow = $state->result_array();

						$query = "Select id, plantdeptname, locationid From plantdept Where id IS NOT NULL Order By plantdeptname";
						$statement = $this->db->query($query);
						$data['ares'] = $statement->result_array(); 

						//if($staterow[0]["type"]=="Agent"){
							$qryagents = "Select * From users_agents Where Userid = '$usid'";
							$stateagents = $this->db->query($qryagents);
							$data['usrdetsagent'] = $stateagents->result_array();							

							$query2 = "Select deptid, deptname From servicingdept Where linactive=false";
							$statement2 = $this->db->query($query2);
							$data['servdept'] = $statement2->result_array(); 

							$query3 = "Select DISTINCT A.Userid, B.fullname From users_agents A left join users B on A.Userid=B.Userid Where A.role='DeptHead'";
							$statement3 = $this->db->query($query3);
							$data['apprs'] = $statement3->result_array();

							$query4 = "Select A.id, A.name, A.cdesc, B.clusterid From clusters A left join users_clusters B on A.id = B.clusterid and B.Userid='$usid' where A.linactive=false Order by A.name";
							$statement4 = $this->db->query($query4);
							$data['clustrs'] = $statement4->result_array();

							$qryowners = "Select * From users_owners Where Userid = '$usid'";
							$stateowners = $this->db->query($qryowners);
							$data['usrdetsowners'] = $stateowners->result_array();		

					//	}

						$this->load->view('settings/Users_Update', $data);

				}
				
		 }
	}
	
	
		public function update_newcust(){
						$txtUserID = $this->session->userdata('usrid');

						$usrtype = $this->input->post("selusrtype");
						$usrid = $this->input->post("txtUserID");
						$usremail = $this->input->post("txtcEmail"); 
						$usrdeptid = $this->input->post("selplantdept");
						$usrdept = $this->input->post("selplantdeptname"); 
						$usrlocation = $this->input->post("sellocid");

						if($this->input->post("selnmetyp")==1){
							$usrfname = strtoupper($this->input->post("txtFName"));
							$usrmi = strtoupper($this->input->post("txtMI"));
							$usrlname = strtoupper($this->input->post("txtLName"));
							$fullname = strtoupper($usrfname)." ".strtoupper($usrmi)." ".strtoupper($usrlname);
						
							$data_to_store = array(
								'Fname' => $usrfname,
								'Lname' => $usrlname,
								'Minit' => $usrmi,
								'cemailadd' => $usremail,
								'fullname' => $fullname,
								'type' => $usrtype,
								'department' => $usrdept,
								'locationid' => $usrlocation,
								'deptid' => $usrdeptid
							);

						}else{
							$fullname = strtoupper($this->input->post("txtFullName"));

							$data_to_store = array(
								'cemailadd' => $usremail,
								'fullname' => $fullname,
								'type' => $usrtype,
								'department' => $usrdept,
								'locationid' => $usrlocation,
								'deptid' => $usrdeptid
							);
							$this->db->query("UPDATE users set Fname=NULL, Lname=NULL, Minit=NULL  Where Userid = '$usrid'");
						}

						$dupzv = $this->Mycrud->update($data_to_store,'users',array("Userid" => $usrid));
						
						if($dupzv){
							
							$ip = $this->input->ip_address();
							

							//UpdateAGENTS
							if($usrtype=="Agent"){
								
								$sqruagent = $this->db->query("SELECT * FROM users_agents Where Userid = '$usrid'");
								$sqruagentCNT = $sqruagent->num_rows();
								
								//users_agents table
								$agentservdept = $this->input->post("selservdept");
								$agentappr = $this->input->post("sellapprid");
								$agentrole = $this->input->post("selagentrole");

								if($sqruagentCNT==0){
									$this->Mycrud->insert('users_agents',array('Userid' => $usrid, 'servicingdeptid' => $agentservdept,'approvaluser' =>	$agentappr,'role' => $agentrole));
								}else{
									$this->Mycrud->update(array('servicingdeptid' => $agentservdept,'approvaluser' =>	$agentappr,'role' => $agentrole),'users_agents',array('Userid' => $usrid));
								}

								//users_clusters table
								$this->db->query("DELETE FROM users_clusters Where Userid = '$usrid'");
								$dataclusters = $this->input->post('chkClustrs');
								foreach($dataclusters as $clusval){
									$data_clusters = array('Userid' => $usrid, 'clusterid' => $clusval,'linactive' =>	false);
									$this->Mycrud->insert('users_clusters',$data_clusters);
								}

								$this->db->query("DELETE FROM users_owners Where Userid = '$usrid'");

							}

							if($usrtype=="User" or $usrtype=="Owners"){
								$this->db->query("DELETE FROM users_agents Where Userid = '$usrid'");
								$this->db->query("DELETE FROM users_clusters Where Userid = '$usrid'");
								$this->db->query("DELETE FROM users_owners Where Userid = '$usrid'");								
							}

							if($usrtype=="Owners"){
								
								$selownerstables = $this->input->post("ownerspldtnme");
								foreach ($selownerstables as $valuesdcfg) {
									$splitxvald = explode(":",$valuesdcfg);
									$this->Mycrud->insert('users_owners',array('Userid' => $usrid, 'plantdeptid' => $splitxvald[0], 'plantdeptname' => $splitxvald[1]));
								}

							}

							//Insert Logfile
							$data2 = array(
								'transid' => 1,
								'ticketid' => $usrid,
								'ddate' => date("Y-m-d H:i:s"),
								'cevent' => "UPDATED",
								'cuser' => $txtUserID,
								'cmodule' => "USERS",
								'cmachine' => $ip,
								'cdescription' => "Updated User Details"
							);
							$this->Mycrud->insert('logfile',$data2);

							echo "True";
							
						}else{
							//echo "False";
							print_r($dupzv);
						}

	}


	public function getuniqueval(){
		$colnme = $this->input->post("colnme");
		$val = $this->input->post("val");
		$typ = $this->input->post("typ");
		$qryftl = "";
		
		if($typ!="New"){
			$qryftl = " and Userid <> '".$typ."'";
		}
			
		$query = "Select * From users Where ".$colnme."='".$val."'".$qryftl;
		$statement = $this->db->query($query);

		if($statement->num_rows() != 0) {
			$row = $statement->result_array();
			echo "Value already exist for ".$row[0]["fullname"];

		}else{
			echo "True";
		}	
	}
	
	public function setuserstat(){
			$stat = $this->input->post("stat");
			$id = $this->input->post("id");

			if($this->Mycrud->update(array("cstatus" => $stat), 'users', array('Userid' => $id)) == TRUE){

									$ip = $this->input->ip_address();

									//Insert Logfile
									$data2 = array(
										'transid' => 0,
										'ticketid' => $id,
										'ddate' => date("Y-m-d H:i:s"),
										'cevent' => "UPDATED",
										'cuser' => $this->session->userdata('usrid'),
										'cmodule' => "USERS",
										'cmachine' => $ip,
										'cdescription' => "Update Status to: ". $stat
									);
									$this->Mycrud->insert('logfile',$data2);

									echo "True";

			}	else{

									echo "False";
			}
	}
	
	
}

?>