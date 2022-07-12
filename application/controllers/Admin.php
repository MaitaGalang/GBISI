<?php
//session_start();
class Admin extends My_Controller
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

      if(empty($this->session->userdata("logged_in")))
      {
         redirect('Logout');
      }
	}

  public function index()
  {
    $data = $this->init_vals();

    $data['loaded_page'] = "dashboard"; 
    $data['form_name'] = "Dashboard";

    //print_r($data);

    $this->load->view('index',$data);
  }

  public function users($typ="",$id=""){

    $data = $this->init_vals();

    $data['userslist'] = $this->Core_model->load_core_data('users','','*','','');
    $data['roleslist'] = $this->Core_model->load_core_data('users_roles','','*','','');

    $data['access'] = $this->check_access(4); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){
        $this->load->view('users_add',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="save"){

      if (in_array("add", $data['access'])){

        $model = $this->Core_model->gquery(1, 'users'); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","New User Successfuly Added."); 

        }else{
          
          $this->session->set_flashdata("error","error on saving."); 

        }

		    redirect("users","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){
        $data['userdetails'] = $this->Core_model->load_core_data('users',$id,'*','','');

        $this->load->view('users_edit',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="update"){

      if (in_array("edit", $data['access'])){

        $model = $this->Core_model->gquery(2, 'users', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","New User Successfuly Updated."); 

        }else{
          
          $this->session->set_flashdata("error","error on updating."); 

        }

		    redirect("users","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){
      if (in_array("delete", $data['access'])){

        $model = $this->Core_model->gquery(3, 'users', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","User Successfuly Deleted."); 

        }else{
          
          $this->session->set_flashdata("error","error on deleting."); 

        }

		    redirect("users","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['userdetails'] = $this->Core_model->load_core_data('users',$id,'*','','');
        $this->load->view('users_details',$data);
      }else{
          redirect("denied");
      } 
    }  
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "users_list"; 
          $data['form_name'] = "Users";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }

  }

  public function roles($typ="",$id=""){

    $data = $this->init_vals();

    $data['roleslist'] = $this->Core_model->load_core_data('users_roles','','*','','');

    $data['nav_menu_all'] = $this->Core_model->load_core_data('nav_menu','','*',array('main_id' => NULL),'main ASC,menu_order ASC');
		$data['subnav_menu_all'] = $this->Core_model->load_core_data('nav_menu','','*','main_id IS NOT NULL','main_id ASC,menu_order ASC','');

    $data['access'] = $this->check_access(5); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){
        $this->load->view('roles_add',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="save"){

      if (in_array("add", $data['access'])){

        $chkacess = $_POST['chk_access']; //checkboxes values

        $menux = $this->Core_model->load_core_data('nav_menu','','*','','main ASC,menu_order ASC');

        $emptyArray = []; 
        $main_fin_access = [];
        foreach($menux as $navmenall){

          foreach($chkacess as $accbox){
            $exmain = explode("_",$accbox);
            $exmainid = explode(":",$exmain[0]);

            if($navmenall->id==$exmainid[1]){
              $emptyArray[] = $exmain[1];
            }
          }

          if(count($emptyArray)!=0){
            @$arraccess[$navmenall->id] = array("id" => $navmenall->id, "main_id" => ($navmenall->main_id == NULL ? 0 : $navmenall->main_id), "access" => $emptyArray);
            $main_fin_access[] = @$arraccess[$navmenall->id];
          }

          $emptyArray = []; 
        }

        $model = $this->Core_model->gquery(1, 'users_roles', '', array('roles' => json_encode($main_fin_access)));  //$type,$table,$id = '',$additional_input='', $clear_fields=''


        if($model['result']){ 
          
          $this->session->set_flashdata("success","New User Role Successfuly Added."); 

        }else{
          
          $this->session->set_flashdata("error","error on saving."); 

        }

		    redirect("roles","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){
        $data['roledetails'] = $this->Core_model->load_core_data('users_roles',$id,'*','','');

        $this->load->view('roles_edit',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="update"){

      if (in_array("edit", $data['access'])){

        $chkacess = $_POST['chk_access']; // checkboxes values

        $menux = $this->Core_model->load_core_data('nav_menu','','*','','main ASC,menu_order ASC');

        $emptyArray = []; 
        $main_fin_access = [];
        foreach($menux as $navmenall){

          foreach($chkacess as $accbox){
            $exmain = explode("_",$accbox);
            $exmainid = explode(":",$exmain[0]);

            if($navmenall->id==$exmainid[1]){
              $emptyArray[] = $exmain[1];
            }
          }

          if(count($emptyArray)!=0){
            @$arraccess[$navmenall->id] = array("id" => $navmenall->id, "main_id" => ($navmenall->main_id == NULL ? 0 : $navmenall->main_id), "access" => $emptyArray);
            $main_fin_access[] = @$arraccess[$navmenall->id];
          }

          $emptyArray = []; 
        }

        $model = $this->Core_model->gquery(2, 'users_roles', $id, array('roles' => json_encode($main_fin_access))); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","User Role Successfuly Updated."); 

        }else{
          
          $this->session->set_flashdata("error","error on updating."); 

        }

		    redirect("roles","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){
      if (in_array("delete", $data['access'])){

        $model = $this->Core_model->gquery(3, 'users_roles', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","User Role Successfuly Deleted."); 

        }else{
          
          $this->session->set_flashdata("error","error on deleting."); 

        }

		    redirect("roles","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['roledetails'] = $this->Core_model->load_core_data('users_roles',$id,'*','','');
        $this->load->view('roles_details',$data);
      }else{
          redirect("denied");
      } 
    }  
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "roles_list"; 
          $data['form_name'] = "User Roles";
          
          $data['userscnt'] = $this->Core_model->load_core_data('users');
          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }

  }

  public function items($typ="",$id=""){
    $data = $this->init_vals();
    $data['itemslist'] = $this->Core_model->load_core_data('items');
    $data['uomlist'] = $this->Core_model->load_core_data('parameters','','',array('type' => 'ITMUOM'),'code ASC');
    $data['classlist'] = $this->Core_model->load_core_data('parameters','','',array('type' => 'ITMCLASS'),'code ASC');

    $data['access'] = $this->check_access(1); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){
        $this->load->view('items_add',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="save"){

      if (in_array("add", $data['access'])){

        $model = $this->Core_model->gquery(1, 'items'); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","New Item Successfuly Added."); 

        }else{
          
          $this->session->set_flashdata("error","error on saving."); 

        }

		    redirect("items","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){
        $data['itemdetails'] = $this->Core_model->load_core_data('items',$id,'*','','');

        $this->load->view('items_edit',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="update"){

      if (in_array("edit", $data['access'])){

        $model = $this->Core_model->gquery(2, 'items', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Item Successfuly Updated."); 

        }else{
          
          $this->session->set_flashdata("error","error on updating."); 

        }

		    redirect("items","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){
      if (in_array("delete", $data['access'])){

        $chkin = $this->Core_model->load_core_data('invoice_dtl','','*',array('items_id' => $id));
        
      if(count($chkin)==0){
        $model = $this->Core_model->gquery(3, 'items', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Item Successfuly Deleted."); 

        }else{
          
         $this->session->set_flashdata("error","error on deleting."); 

        }
      }else{
        $this->session->set_flashdata("error","Item has reference invoice.");
      }

		   redirect("items","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      //if (in_array("view", $data['access'])){
     //   $data['paramdetails'] = $this->Core_model->load_core_data('parameters',$id,'*','','');
     //   $this->load->view('parameters_details',$data);
      //}else{
      //    redirect("denied");
     // } 
    } 
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "items_list"; 
          $data['form_name'] = "Items";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
  }

  public function parameters($typ="",$id=""){
    $data = $this->init_vals();
    $data['paramlist'] = $this->Core_model->load_core_data('parameters');

    $data['access'] = $this->check_access(7); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){
        $this->load->view('parameters_add',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="save"){

      if (in_array("add", $data['access'])){

        $model = $this->Core_model->gquery(1, 'parameters'); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","New Parameter Successfuly Added."); 

        }else{
          
          $this->session->set_flashdata("error","error on saving."); 

        }

		    redirect("parameters","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){
        $data['paramdetails'] = $this->Core_model->load_core_data('parameters',$id,'*','','');

        $this->load->view('parameters_edit',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="update"){

      if (in_array("edit", $data['access'])){

        $model = $this->Core_model->gquery(2, 'parameters', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Parameter Successfuly Updated."); 

        }else{
          
          $this->session->set_flashdata("error","error on updating."); 

        }

		    redirect("parameters","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){
      if (in_array("delete", $data['access'])){

        $data_chkin = $this->Core_model->load_core_data('parameters',$id,'*');

       // echo $this->db->last_query()."<br><br>";

        if($data_chkin->type=='ITMCLASS'){
          $chkin = $this->Core_model->load_core_data('items','','*',array('classification' => $data_chkin->code));
        }elseif($data_chkin->type=='CUSCLASS'){
          $chkin = $this->Core_model->load_core_data('customers','','*',array('classification' => $data_chkin->code));
        }elseif($data_chkin->type=='ITMUOM'){
          $chkin = $this->Core_model->load_core_data('items','','*',array('uom' => $data_chkin->code));
        }

       // echo "Hello: ".count($chkin)."<br>";

        //echo $this->db->last_query();

        
      if(count($chkin)==0){
        $model = $this->Core_model->gquery(3, 'parameters', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Parameter Successfuly Deleted."); 

        }else{
          
         $this->session->set_flashdata("error","error on deleting."); 

        }
      }else{
        $this->session->set_flashdata("error","Parameter has reference.");
      }

		   redirect("parameters","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['paramdetails'] = $this->Core_model->load_core_data('parameters',$id,'*','','');
        $this->load->view('parameters_details',$data);
      }else{
          redirect("denied");
      } 
    } 
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "parameters_list"; 
          $data['form_name'] = "Parameters";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
  }

  public function customers($typ="",$id=""){
    $data = $this->init_vals();
    $data['custslist'] = $this->Core_model->load_core_data('customers');
    $data['strtyplist'] = $this->Core_model->load_core_data('parameters','','',array('type' => 'STRTYP'),'description ASC');
    $data['paytrmlist'] = $this->Core_model->load_core_data('parameters','','',array('type' => 'PAYTERM'),'description ASC'); 
    $data['pmlist'] = $this->Core_model->load_core_data('price_matrix_codes','','','','description ASC');

    $data['access'] = $this->check_access(6); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){
        $this->load->view('customers_add',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="save"){

      if (in_array("add", $data['access'])){

        $model = $this->Core_model->gquery(1, 'customers'); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","New Customer Successfuly Added."); 

        }else{
          
          $this->session->set_flashdata("error","error on saving."); 

        }

		    redirect("customers","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){
        $data['custdetails'] = $this->Core_model->load_core_data('customers',$id,'*','','');

        $this->load->view('customers_edit',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="update"){

      if (in_array("edit", $data['access'])){

        $model = $this->Core_model->gquery(2, 'customers', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Customer Successfuly Updated."); 

        }else{
          
          $this->session->set_flashdata("error","error on updating."); 

        }

		    redirect("customers","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){
      if (in_array("delete", $data['access'])){

        $chkin = $this->Core_model->load_core_data('invoice_hdr','','*',array('customer_id' => $id));
        
      if(count($chkin)==0){
        $model = $this->Core_model->gquery(3, 'customers', $id); 

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Customer Successfuly Deleted."); 

        }else{
          
         $this->session->set_flashdata("error","error on deleting."); 

        }
      }else{
        $this->session->set_flashdata("error","Customer has reference invoice.");
      }

		   redirect("customers","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['custdetails'] = $this->Core_model->load_core_data('customers',$id,'*','','');
        $this->load->view('customers_details',$data);
      }else{
          redirect("denied");
      } 
    } 
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "customers_list"; 
          $data['form_name'] = "Customers";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
  } 


  public function price_matrix($typ="",$id=""){
    $data = $this->init_vals();
    
    $query = $this->db->query("Select batch_no,effect_date,MAX(date_created) as date_created, string_agg(pm_code, ' | ') AS code_list FROM price_matrix_hdr WHERE company_id='".$this->session->userdata('comp_id')."' and is_active <> 3 GROUP BY batch_no,effect_date,date_created::TIMESTAMP::DATE ORDER BY MAX(date_created) DESC");
    //$queryres = $this->db->get(); 

    $data['pmlist'] = $query->result();
    $data['itemslist'] = $this->Core_model->load_core_data('items');

    $data['access'] = $this->check_access(2); //id in nav_menu table

    if($typ=="add"){
      if (in_array("add", $data['access'])){

       // print_r($_POST);
        
        $data['loaded_page'] = "matrix_add"; 
        $data['form_name'] = "New Price Matrix";

        $data['versions'] = $_POST['hdnvers'];

          $this->load->view('index',$data);

      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="savehdr"){

      if (in_array("add", $data['access'])){

        //deffect: txtdeffect, desc: txtcdesc, typ: arrsplit[i], batchno: batchno
        $datahdr = array(
          'batch_no' => $_POST['batchno'],
          'transaction_no' => $_POST['tranno'],
          'effect_date' => $_POST['deffect'],
          'remarks' => $_POST['desc'],
          'pm_code' => $_POST['typ']
        );
       
        $model = $this->Core_model->custom_insert('price_matrix_hdr',$datahdr); 

        if($model['result']){ 
          
          echo $model['query_id']; 

        }else{
          
          echo "Error";

        }

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="savedtl"){ //valzid: valzid, valzcbb: valzcbb, valzax: valzax, valzdsc: valzdsc, valzuom: valzuom, tranno: trancode+arrsplit[i] 
      
      $datadtl = array(
        'hdr_id' => $_POST['refid'],
        'items_id' => $_POST['valzid'],
        'cbb_code' => $_POST['valzcbb'],
        'ax_code' => $_POST['valzax'],
        'description' => $_POST['valzdsc'],
        'uom' => $_POST['valzuom'],
        'price' => $_POST['price']
      );
     
      $model = $this->Core_model->custom_insert('price_matrix_dtl',$datadtl); 

      if($model['result']){ 
        
        //echo $model['query_id']; 
        echo "True";

      }else{
        
        echo "Error";

      }
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){

        $data['pmhdr'] = $this->Core_model->load_core_data('price_matrix_hdr','','*',array('batch_no' => $id));
        foreach($data['pmhdr'] as $value){

          $ids[] = $value->id;
          $idsvers[] = $value->pm_code;
    
        }

        $data['versions'] = $idsvers;

        $data['pmdtl'] = $this->Core_model->load_core_data('price_matrix_dtl','','*','','',array('hdr_id' => $ids));
        $query = $this->db->query("Select DISTINCT items_id,cbb_code,ax_code,description,uom FROM price_matrix_dtl WHERE company_id='".$this->session->userdata('comp_id')."' and is_active = 1 and hdr_id in ('".implode('\',\'',$ids)."')");

        $data['pmdtlitms'] = $query->result();

        $data['loaded_page'] = "matrix_edit"; 
        $data['form_name'] = "Update Price Matrix: ".$data['pmhdr'][0]->batch_no;

        $this->load->view('index',$data);
        
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="updatehdr"){

      if (in_array("edit", $data['access'])){

        $datahdr = array(
          'effect_date' => $_POST['deffect'],
          'remarks' => $_POST['desc']
        );
       
        $model = $this->Core_model->custom_update('price_matrix_hdr',$datahdr, array('batch_no' => $_POST['batchno'], 'transaction_no' => $_POST['tranno'])); 

        if($model['result']){ 
          //backup muna
          $query = $this->db->query("Select date_created,created_by,modified_at,is_active,deleted_at,hdr_id,items_id,cbb_code,ax_code,description,uom,price From price_matrix_dtl Where company_id='".$this->session->userdata('comp_id')."' and hdr_id = '".$model['query_id']."'");
          foreach ($query->result() as $row) {
            $this->db->insert('price_matrix_dtlbckup',$row);
          }

          $model2 = $this->Core_model->gquery(4,'price_matrix_dtl','',array('hdr_id' => $model['query_id']));
          if($model['result']){
            echo $model['query_id'];
          // echo $this->db->last_query();
          }else{
            echo "Error";
          }

        }else{
          
          echo "Error";

        }

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="delete"){

      if (in_array("delete", $data['access'])){

        $ifyes = true;

        $ddel = $this->Core_model->load_core_data('price_matrix_hdr','','',array('batch_no' => $id));
        foreach ($ddel as $row) {
          $model = $this->Core_model->gquery(3, 'price_matrix_hdr', $row->id);
          if(!$model['result']){ 
            $ifyes = false;
          }
        }

        if( $ifyes){ 
          
          $this->session->set_flashdata("success","Price Matrix Successfuly Deleted."); 

        }else{
          
         $this->session->set_flashdata("error","error on deleting."); 

        }

		   redirect("price_matrix","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['pmhdr'] = $this->Core_model->load_core_data('price_matrix_hdr','','*',array('batch_no' => $id));
        foreach($data['pmhdr'] as $value){

          $ids[] = $value->id;
          $idsvers[] = $value->pm_code;
    
        }

        $data['versions'] = $idsvers;

        $data['pmdtl'] = $this->Core_model->load_core_data('price_matrix_dtl','','*','','',array('hdr_id' => $ids));
        $query = $this->db->query("Select DISTINCT items_id,cbb_code,ax_code,description,uom FROM price_matrix_dtl WHERE company_id='".$this->session->userdata('comp_id')."' and is_active = 1 and hdr_id in ('".implode('\',\'',$ids)."')");

        $data['pmdtlitms'] = $query->result();

        $data['loaded_page'] = "matrix_details"; 
        $data['form_name'] = "Price Matrix Details: ".$data['pmhdr'][0]->batch_no;

        $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
    elseif($typ=="load"){

      $xlist = $this->Core_model->load_core_data('price_matrix_codes');

      echo json_encode($xlist);
      
    }
    else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "matrix_list"; 
          $data['form_name'] = "Price Matrix";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
  }

}