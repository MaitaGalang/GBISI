<?php
//session_start();
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','html','string'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('User_model');
		$this->load->model('Login_model');
        $this->load->model('Core_model');
	}

  public function index()
  {
	  $sess_logged = $this->session->userdata('login');
		   
	  if($sess_logged==TRUE)
	  {

		redirect("dashboard");
		  
	  }else{
	
			// get form input
			$user = $this->input->post("user");
	    	$password = $this->input->post("password");

			if(isset($user) && isset($password)){
			// form validation
			$this->form_validation->set_rules("user", "User Name", "trim|required");
			$this->form_validation->set_rules("password", "Password", "trim|required");
		
			if ($this->form_validation->run() == FALSE)
	        {
				// validation fail
				$this->session->set_flashdata('msg','');
				$this->load->view('Login');
			}
			else
			{
				// check for user credentials
				$uresult = $this->User_model->get_user($user, $password);

                if($uresult == "False"){
                    $this->session->set_flashdata('msg', '<div class="col-12 alert alert-danger text-center text-sm">Wrong Password!</div>');
                    $this->load->view('Login');
                }else{
                    if (count($uresult) > 0)
                    {
                        // set session
                        
                        if($uresult[0]->is_active == 'true'){
                            $this->session->set_flashdata('msg', '<div class="col-12 alert alert-danger text-center text-sm">Inactive User!</div>');
                            $this->load->view('Login');					
                        }
                        else{

                            $this->Core_model->tologfile('Login','Logged In',$uresult[0]->user_id);

                            $sess_data = array('logged_in' => TRUE, 'uname' => $uresult[0]->fullname, 'usrid' => $uresult[0]->user_id, 'cstatus' => $uresult[0]->is_active, 'clogpic' => $uresult[0]->user_image, 'roleid' => $uresult[0]->role_id, 'usridval' => $uresult[0]->id);

                            $this->session->set_userdata($sess_data);

                            //select company
                            $selcom = $this->Core_model->load_core_data('users_company','','',array('user_id' => $uresult[0]->id));                     
                            echo count($selcom);

                            if(count($selcom)==1){
                                $this->session->set_userdata(array('comp_id' => $selcom[0]->company_id));
                                redirect("dashboard");

                            }else{


                                redirect("login_company");
                            }
                            
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('msg', '<div class="col-12 alert alert-danger text-center text-sm">Wrong User-ID!</div>');
                        $this->load->view('Login');
                    }
                }
			}

			}
			else{

					$this->session->set_flashdata('msg','');
					$this->load->view('Login');

			}
	  }
 }

    public function login_company($typ=""){

        if($typ=="log"){

            $this->session->set_userdata(array('comp_id' => $_POST['company']));
            redirect("dashboard");

        }else{
        
            $data['selcom'] = $this->Core_model->load_core_data('users_company','','',array('user_id' => $this->session->usridval));
            $data['selcomall'] = $this->Core_model->load_core_data('company');

            $data['loaded_page'] = "Login_company"; 

            $this->load->view('Login_company',$data);

        }

    }
	

	public function failed(){
		$this->load->view('failed',$data);
	}
	
	public function relog(){
		redirect('login');
	}
	
	 /**
     * This function used to generate reset password request link
     */

	public function forgotPassword(){
				
		$this->load->view('ForgotPassword');
					
	}

    function resetPasswordUser()
    {
        $status = '';
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');

        $xstat = $this->form_validation->run();
       // print_r($this->input->post('login_email').": ".$xstat);
                
        if($this->form_validation->run() == FALSE)
        {
           redirect('ForgotPassword');

        }
        else 
        {

            $email = $this->input->post('login_email');
            
            if($this->Login_model->checkEmailExist($email)=="X")
            {
                $status = 'invalid';
                $this->session->set_flashdata($status, "This email is an INACTIVE account.");

			}elseif($this->Login_model->checkEmailExist($email)=="Y")
			{
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['date_created'] = date('Y-m-d H:i:s');
                $data['agent'] = $_SERVER['HTTP_USER_AGENT']; //getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->Login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    //$data1['act_id'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $data1['act_id'] = $data['activation_id'];
                    $data1['act_email'] = $encoded_email;
                    $userInfo = $this->Login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->fullname;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = $this->resetSendPasswordEmail($data1);

					//$this->resetSendPasswordEmail($data1);

                   // print_r($sendStatus);

                    if($sendStatus){
                        $this->Core_model->tologfile('Password Reset','Reset',$userInfo[0]->user_id);

                       $status = "send";
                       $this->session->set_flashdata($status, "Reset password link sent successfully, please check your email.");
                    }else {

                       $status = "notsend";
                       $this->session->set_flashdata($status, "Email has been failed, try again.");
					  // $this->session->set_flashdata($status, $sendStatus);
                    }
                }
                else
                {
                    $status = 'unable';
                    $this->session->set_flashdata($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                $this->session->set_flashdata($status, "This email is not registered with us.");
            }

            redirect('ForgotPassword');

           // echo $status;
        }
    }

    // This function used to reset the password 
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->Login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);

        }
        else
        {
            $status = 'invalid';
            $this->session->set_flashdata($status, "Wrong or Expired Link!");
            redirect('/ForgotPassword');

            //redirect('/login');
                    //$this->session->set_flashdata('msg','<div class="col-12 alert alert-danger text-center text-sm">Wrong or Expired Link!</div>');
                   // $data = array('title' => $this->config->item('title'));
                   // $this->load->view('Login',$data);
            //echo $is_correct.":".$email.":".$activation_id;
        }
    }
    
    // This function used to create new password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->Login_model->checkActivationDetails($email, $activation_id);
            //$is_correct = 1;
            if($is_correct == 1)
            {            
				//array('password = ' => crypt($password, gen_salt('bf', 8)), 'updated_at' =>  date('Y-m-d H:i:s')    
                $extz = $this->User_model->createPasswordUser($email, $password);
echo $extz;
                if($extz==true){
					$status = 'alert-success';
                	$message = 'Password changed successfully';
				}else{
					$status = 'alert-danger';
                	$message = 'Error Changing Password!';
				}
				
				//$message = $extz;
				
				
            }
            else
            {
                //$status = 'error';
                
				$status = 'alert-danger';
				$message = 'Email and Activation ID error!';
				
            }
            
            
			$this->session->set_flashdata('msg', '<div class="col-12 alert '.$status.' text-center text-sm">'.$message.'</div>');
            
			$data = array('title' => $this->config->item('title'));
			$this->load->view('Login',$data);

        }
    }



/////////SENDING EMAIL

    function resetSendPasswordEmail($detail)
    {
        $data["data"] = $detail;
		
		$mesg = $this->load->view('email/resetPassword', $data, TRUE);
		
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->set_crlf( "\r\n" );
		
		$this->email->from('myxwebportal@gmail.com', 'GBI Invoicing System');
		$this->email->to($detail["email"]);
		
		$this->email->subject('Reset Password');
		$this->email->message($mesg);
		
		$status = $this->email->send();
		
		return $status;

        //return $this->email->print_debugger();

        //print_r($this->email->print_debugger());
	}
	
}
