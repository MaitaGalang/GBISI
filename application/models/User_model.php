<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function __construct()
    {
        //parent::__construct();
    }
	
	function get_user($usr, $pwd)
	{
		
		$query = $this->db->query("SELECT A.id, A.user_id, A.password, A.fullname, A.is_active, A.user_image, A.role_id FROM users A Where A.user_id = '$usr' and A.is_active = 1");       
        $user = $query->result();
		$valx = $query->result_array();

		//echo count($user);
        if(!empty($user)){    
			if(verifyHashedPassword($pwd, $valx[0]['password'])){       
         		return $user;
			}else{
				return "False";
			}
        } else {
			
          		return array();

        }

        

	}

	function get_user_by_email($eml)
	{
		$this->db->where('cemailadd', $eml);
        $query = $this->db->get('users');
		return $query->result();
	}
	
	// get user
	function get_user_by_id($id)
	{
		$this->db->where('id', $id);
        $query = $this->db->get('users');
		return $query->result();
		
	}
	
	// insert
	function insert($table,$data)
    {
		return $this->db->insert($table, $data);
	}
	
	// reset password to password
	function update_pass($data)
    {
		extract($data);
		$this->db->where('userid', $userid);
		$this->db->update('users', array('password' => crypt($password, gen_salt('bf', 8)), 'updated_at' => $updated_at));
		
		$num = $this->db->affected_rows();
		if($num > 0){
			return true;
		}else{
			return false;
		}
	}

	function createPasswordUser($email,$password){

		$dte = date('Y-m-d H:i:s');
		$query = $this->db->query("UPDATE users set password=crypt('".$password."', gen_salt('bf', 8)), modified_at='".$dte."' where email='".$email."'");    

//echo "UPDATE \"users\" set \"password\"=crypt('$password', gen_salt('bf', 8)), \"updated_at\"='$dte' where \"cemailadd\"='$email'";

		$num = $this->db->affected_rows();

		if($num > 0){
			$this->db->delete('users_reset_password', array('email'=>$email));
			return true;
		}else{
			return false;
		}
		
		//echo "UPDATE \"users\" set \"password\"=crypt('".$password."', gen_salt('bf', 8)), \"updated_at\"='".$dte."' where \"cemailadd\"='".$email."'";
	}
	
	function get_timeline($usr){
		$query = $this->db->query("SELECT * FROM logfile Where cuser = '$usr' and DATE(ddate) between DATE('".date('Y-m-d', strtotime('-7 days'))."') and DATE('".date('Y-m-d')."') order by ddate DESC");
		return $query->result_array(); 
					
	}

	function Changepass($uid,$password){
		$dte = date('Y-m-d H:i:s');
		$pwrd = getHashedPassword($password);
		$query = $this->db->query("UPDATE users set password='".$pwrd."', modified_at='$dte' where user_id='$uid'");       

		$num = $this->db->affected_rows();
		if($num > 0){
			return true;
		}else{
			return false;
		}
	}

	function ChangeProfile($uid,$ppic){
		$dte = date('Y-m-d H:i:s');
		$query = $this->db->query("UPDATE users set user_image='".$ppic."', modified_at='".$dte."' where user_id='".$uid."'");       

		$num = $this->db->affected_rows();
		if($num > 0){
			return true;
		}else{
			return false;
		}
	}

}?>