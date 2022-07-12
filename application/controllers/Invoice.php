<?php
//session_start();
class Invoice extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','html','string'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
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

  public function invoice_list($typ="",$id=""){

    $data = $this->init_vals();

    $data['invlist'] = $this->Core_model->load_core_data_all('invoice_hdr');
   
    $data['customers'] = $this->Core_model->load_core_data_all('customers');

    $data['itemslist'] = $this->Core_model->load_core_data('items');
    $data['cust'] = $this->Core_model->load_core_data('customers');

    $data['access'] = $this->check_access(8); //id in nav_menu table

    if($typ=="add"){
      $add_access = $this->check_access(9);
      if (in_array("add", $add_access)){

        // print_r($_POST);
        
         $data['loaded_page'] = "transactions/invoice_add"; 
         $data['form_name'] = "New Invoice";
 
        $this->load->view('index',$data);
 
       }else{
           redirect("denied");
       }
    }
    elseif($typ=="edit"){
      if (in_array("edit", $data['access'])){ 
      
        $data['invheader'] = $this->Core_model->load_core_data_all('invoice_hdr',$id);
        $data['invdetails'] = $this->Core_model->load_core_data_all('invoice_dtl','','',array('transaction_no' => $data['invheader']->transaction_no));

        $data['loaded_page'] = "transactions/invoice_edit"; 
        $data['form_name'] = "Update Invoice: ".$data['invheader']->order_no;
 
        if($data['invheader']->is_active==2){
          redirect("invoices");
        }else{
          $this->load->view('index',$data);
        }

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
    elseif($typ=="cancel"){
      if (in_array("cancel", $data['access'])){

        $model = $this->Core_model->gquery(5, 'invoice_hdr', $id);

        if($model['result']){ 
          
          $this->session->set_flashdata("success","Invoice Successfully Cancelled."); 

        }else{
          
          $this->session->set_flashdata("error","error on cancelling."); 

        }

		    redirect("invoices","refresh");

      }else{
        redirect("denied");
      } 
    }
    elseif($typ=="view"){
      if (in_array("view", $data['access'])){
        $data['invhdr'] = $this->Core_model->load_core_data_all('invoice_hdr','','*',array('transaction_no' => $id));
        $data['invdtl'] = $this->Core_model->load_core_data_all('invoice_dtl','','*',array('transaction_no' => $id));

        $data['cuslist'] = $this->Core_model->load_core_data_all('customers');


        $this->load->view('transactions/invoice_details',$data);
      }else{
          redirect("denied");
      } 
    }  
    elseif($typ=="view_order"){
      $data['invhdr'] = $this->Core_model->load_core_data_all('soh','','*',array('order_no' => $id));
      $data['invdtl'] = $this->Core_model->load_core_data_all('sol','','*',array('order_no' => $id));

      $data['itmlist'] = $this->Core_model->load_core_data_all('items');

      $this->load->view('transactions/order_details',$data);
    }
    elseif($typ=="load_batch_trans"){

      $dtefr = $_REQUEST['dfrom'];
      $dteto = $_REQUEST['dteto'];

      $xlist = $this->Core_model->load_core_data('invoice_hdr','','',array('invoice_date >=' => $dtefr, 'invoice_date <=' => $dteto, 'lprinted' => 'f'));

      echo json_encode($xlist);

    }elseif($typ=="print_preview"){
      

     // print_r($_POST['chkTranNo']);

     // echo "<br>";

     // echo implode(",", $_POST['chkTranNo']);
      //echo "<br>";

      $data['invhdr'] = $this->Core_model->load_core_data('invoice_hdr','','*','','',array('id' => $_POST['chkTranNo']));
     // echo $this->db->last_query();
      //echo "<br>";
      foreach($data['invhdr'] as $gettrans){
        @$translist[] = $gettrans->transaction_no;
      }

      $data['invdtl'] = $this->Core_model->load_core_data('invoice_dtl','','*','','',array('transaction_no' => @$translist));
      //echo $this->db->last_query();

      $data['custlist'] = $this->Core_model->load_core_data_all('customers');
      $data['itmlist'] = $this->Core_model->load_core_data_all('items');
      $data['params'] = $this->Core_model->load_core_data_all('parameters', '','',array('type' => 'PAYTERM'));

      $data['chkTranNo'] = $_POST['chkTranNo'];

      $this->load->view('transactions/invoice_preview',$data);

      

    }elseif($typ=="print"){

      //set as printed
      $model = $this->db->query("Update invoice_hdr set lprinted=true where id in('".implode("','", $_POST['chkTranNo'])."')");

      if($model){
        $data['invhdr'] = $this->Core_model->load_core_data('invoice_hdr','','*','','',array('id' => $_POST['chkTranNo']));
        foreach($data['invhdr'] as $gettrans){
          @$translist[] = $gettrans->transaction_no;
        }
  
        $data['invdtl'] = $this->Core_model->load_core_data('invoice_dtl','','*','','',array('transaction_no' => @$translist));
  
        $data['custlist'] = $this->Core_model->load_core_data_all('customers');
        $data['itmlist'] = $this->Core_model->load_core_data_all('items');
        $data['params'] = $this->Core_model->load_core_data_all('parameters', '','',array('type' => 'PAYTERM'));
  
        $data['chkTranNo'] = $_POST['chkTranNo'];
  
        $this->load->view('transactions/invoice_print',$data);

      }
 
     }else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "transactions/invoice_list"; 
          $data['form_name'] = "Invoice";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }

  }

  public function invoice_upload($typ="",$id=""){
    $data = $this->init_vals();

    $data['loaded_page'] = "transactions/invoice_upload"; 
    $data['form_name'] = "Invoice Uploading";

    //print_r($data);

   $data['access'] = $this->check_access(10); //id in nav_menu table

    if($typ=="save")
    {
      if (in_array("add", $data['access'])){ 
        
          $invhdr = $this->Core_model->load_core_data_all('soh');
          $invdtl = $this->Core_model->load_core_data_all('sol');

            foreach($invhdr as $rssoh) {
              $get_cust = $this->Core_model->load_core_data('customers','','',array('cbb_code' => $rssoh->cust_code));
                
              $tranno = $rssoh->order_type.$get_cust[0]->cbb_code.date('mdY', strtotime($rssoh->delivery_date))."_".$rssoh->order_no;

              $reschk = $this->Core_model->load_core_data('invoice_hdr','','',array('transaction_no' => $tranno));
              //print_r($reschk);
              if (count($reschk)==0){ //check if header no. already exist

                    //get customer details by CBB Code;
                    if(count($get_cust)==0){
                      echo "Customer Error: ".$tranno;
                    }else{
                      $data_ins = array(
                        'transaction_no' => $tranno,
                        'customer_id' => $get_cust[0]->id,
                        'customer_cbb_code' => $get_cust[0]->cbb_code,
                        'customer_ax_code' => $get_cust[0]->ax_code,
                        'invoice_date' => $rssoh->delivery_date,
                        'order_no' => $rssoh->order_no,
                        'order_type' => $rssoh->order_type  

                      );
                    
                      $model = $this->Core_model->custom_insert('invoice_hdr', $data_ins); 

                      if($model['result']){ 
                        
                        //$this->session->set_flashdata("success","New User Successfuly Updated."); 
                        echo "Header: ".$tranno;

                      }else{
                        
                      // $this->session->set_flashdata("error","error on updating."); 
                      echo "Error: ".$tranno;

                      }
                    }

              }
            }  
              
            foreach($invdtl as $rssol) {

                  $get_cust = $this->Core_model->load_core_data('customers','','',array('cbb_code' => $rssol->cust_code));

                  $tranno = $rssol->order_type.$get_cust[0]->cbb_code.date('mdY', strtotime($rssol->delivery_date))."_".$rssol->order_no;

                  $reschk = $this->Core_model->load_core_data('invoice_hdr','','',array('transaction_no' => $tranno));
                  if (count($reschk)==0){
                    echo "Customer Error SOL: ".$tranno;
                  }else{

                      $get_itms = $this->Core_model->load_core_data('items','','',array('cbb_code' => $rssol->item_code)); 
                      //$get_itms_price = $this->Core_model->load_core_data('items','','',array('cbb_code' => $line[13]));

                      if(count($get_itms)==0){
                        echo "Item Error ".$line[13]." : ".$tranno;
                      }else{

                        $priceget = $this->get_price($get_itms[0]->id,$rssol->delivery_date,$get_cust[0]->price_code); //get_price($itm="",$deldate="",$pricecode="")

                        $data_ins = array(
                          'transaction_no' => $tranno,
                          'items_id' => $get_itms[0]->id,
                          'cbb_code' => $get_itms[0]->cbb_code,
                          'ax_code' => $get_itms[0]->ax_code,
                          'description' => $get_itms[0]->description,
                          'uom' => $rssol->uom,
                          'quantity' => $rssol->qty,
                          'price' => $priceget,
                          'amount' => $priceget*$rssol->qty
                        );
                      
                        $model = $this->Core_model->custom_insert('invoice_dtl', $data_ins); 

                        if($model['result']){ 
                          
                          //$this->session->set_flashdata("success","New User Successfuly Updated."); 
                        //  echo "Detail: ".$tranno."-".$get_itms[0]->cbb_code."$ ".$priceget."<br>";

                        }else{
                          
                        // $this->session->set_flashdata("error","error on updating."); 
                      //  echo "DetError: ".$tranno;

                        }
                      }
                  }
            }

            //TOTAL GROSS lahat

            foreach($invhdr as $rssoh) {
              $get_cust = $this->Core_model->load_core_data('customers','','',array('cbb_code' => $rssoh->cust_code));
              $tranno = $rssoh->order_type.$get_cust[0]->cbb_code.date('mdY', strtotime($rssoh->delivery_date))."_".$rssoh->order_no;

              $query = $this->db->query("Select SUM(amount) as gross from invoice_dtl where transaction_no = '".$tranno."'");
              $queryres = $query->result();

              if($queryres[0]->gross>0){
                $query = $this->db->query("Update invoice_hdr set gross='".$queryres[0]->gross."' where transaction_no = '".$tranno."'");
              }

            }


            fclose($file);

            redirect('invoices');

      }else{
        redirect("denied");
      }

    }
    else {

      $this->load->view('index',$data);

    }
  }

  function get_price($itm="",$deldate="",$pricecode=""){

    //filter all PM of item
    $itmpms = $this->Core_model->load_core_data('price_matrix_dtl','','hdr_id',array('items_id' => $itm));
    if(count( $itmpms)==0){
      return 0;
    }else{
      foreach($itmpms as $hrdx){
        @$fmr[] = $hrdx->hdr_id;
      }

    $allhdr = $this->Core_model->load_core_data('price_matrix_hdr','','',array('pm_code' => $pricecode, 'effect_date <=' => $deldate),'effect_date DESC',array('id' => @$fmr));

      //get the detail
      if(count($allhdr)>0){
        $itmpmfin = $this->Core_model->load_core_data('price_matrix_dtl','','',array('items_id' => $itm, 'hdr_id' => $allhdr[0]->id));
        return  $itmpmfin[0]->price;
      }else{
        return 0;
      }

    }

  }

  public function invoice_uploadcheck(){

   $data['access'] = $this->check_access(10); //id in nav_menu table

   @$tocheck = "True";

      if (in_array("add", $data['access'])){ 

        $config['upload_path'] = './assets/csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 2000; 
        $config['overwrite'] = false;
        //$config['max_width'] = 1500;
        //$config['max_height'] = 1500;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('invfile')) {
            $error = array('error' => $this->upload->display_errors());

            //$this->load->view('files/upload_form', $error);

            print_r($error);
        } else {
          
          $this->Core_model->gquery(4,'soh');
          $this->Core_model->gquery(4,'sol');

            $data = $this->upload->data();
            $file_path =  './assets/csv/'.$data['file_name'];

            $file = fopen($file_path, 'r');

            while (($line = fgetcsv($file)) !== FALSE) {
              if($line[0]!=""){
                
                if($line[0]=="SOH"){

                  $itmpms = $this->Core_model->load_core_data('customers','','',array('cbb_code' => $line[1]));
                  if(count( $itmpms)==0){
                    @$custrmschk = "Customer didn't exist";
                    @$tocheck = "False";
                  }else{
                    @$custrmschk = "";
                  }

                  $data_ins = array(
                    'order_no' => $line[4],
                    'delivery_date' => $line[2],
                    'cust_code' => $line[1],
                    'cust_name' => $line[8],
                    'order_type' => $line[3],
                    'tag' => 'N',
                    'remarks' => @$custrmschk 
                  );
                    
                  $model = $this->Core_model->custom_insert('soh', $data_ins); 
                }
              
                if($line[0]=="SOL") {

                  $itmpms = $this->Core_model->load_core_data('items','','',array('cbb_code' => $line[13]));
                  if(count($itmpms)==0){
                    @$itmzrmschk = "Item didn't exist";
                    @$tocheck = "False";
                  }else{
                    @$itmzrmschk = "";

                    if(strtoupper(@$itmzrmschk[0]->unit)==strtoupper($line[15])){
                      @$itmzrmschk = "UOM Don't Match";
                      @$tocheck = "False";
                    }
                  }

                  if(@$itmzrmschk!=""){
                    $this->db->query("Update soh set remarks='With Error!' where order_no = '".$line[4]."'");
                  }

                    $data_ins = array(
                      'order_no' => $line[4],
                      'delivery_date' => $line[2],
                      'cust_code' => $line[1],
                      'item_code' => $line[13],
                      'uom' => $line[15],
                      'qty' => $line[16],
                      'remarks' => @$itmzrmschk,
                      'order_type' => $line[3]
                    );
                      
                  $model = $this->Core_model->custom_insert('sol', $data_ins);
                }

              }
            }
            fclose($file);

            echo $tocheck;

            if(@$tocheck=="False"){
              redirect('invoice_vieworders');
            }
            else{
              redirect('upload_csv/save');
            }
          
        }

      }else{
       // redirect("denied");
      }

  }

  public function invoice_vieworders(){

    $data = $this->init_vals();

    $data['access'] = $this->check_access(10); //id in nav_menu table

    $data['loaded_page'] = "transactions/csv_list"; 
    $data['form_name'] = "View Orders";

    $data['soh'] = $this->Core_model->load_core_data_all('soh');

    $this->load->view('index',$data);

  }

  public function batch_print(){
    $data = $this->init_vals();

    $data['access'] = $this->check_access(11); //id in nav_menu table

    if (in_array("print", $data['access'])){

      $data['loaded_page'] = "transactions/batch_printing"; 
      $data['form_name'] = "Batch Printing";

      $data['invhdr'] = $this->Core_model->load_core_data_all('invoice_hdr');

      $this->load->view('index',$data);

    }else{    
      if (in_array("view", $data['access'])){
          $data['loaded_page'] = "transactions/invoice_list"; 
          $data['form_name'] = "Invoice";

          $this->load->view('index',$data);
      }else{
          redirect("denied");
      } 
    }
  }
  

}