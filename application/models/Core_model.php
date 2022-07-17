<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Core_model extends CI_Model
{
    public function chktblcol($table=""){

        if($table=="users_company"){
            return "False";
        }else{
            $query = $this->db->query("SELECT column_name FROM information_schema.columns WHERE table_name='".$table."' and column_name='company_id'");
            $queryres = $query->result();
            if(count($queryres)==0){   
                return "False";
            }else{
                return "True";
            }
        }

    }
    
    public function load_core_data($table,$id='',$select='',$condition='',$order='',$wherein='',$groupby=''){ //Select all, not deleted
 		
        if($select){
            $this->db->select($select);
        }
        if($condition){
            $this->db->where($condition);
        }
        if($groupby){
            $this->db->group_by($groupby);
        }
        if($order){
            $this->db->order_by($order);
        }
        if($wherein){
            foreach($wherein as $key => $value){
                $this->db->where_in($key,$value);
            }          
        }
        
       $this->db->from($table);
       if($id){ 
           $this->db->where(array('is_active'=>1, 'id'=>$id));

           if($this->chktblcol($table)=="True"){
            $this->db->where(array('company_id' => $this->session->userdata('comp_id')));
           }

           $query = $this->db->get(); 
           return $query->row(); 
       }else{

            if($this->chktblcol($table)=="True"){
                $this->db->where(array('company_id' => $this->session->userdata('comp_id')));
            }

           $this->db->where(array('is_active'=>1));
           $query = $this->db->get(); 
           return $query->result();
       }
        

    }

    public function load_core_data_all($table,$id='',$select='',$condition='',$order='',$wherein=''){  //Select all, all even if deleted
        
        if($select){
            $this->db->select($select);
        }
        if($condition){
            $this->db->where($condition);
        }
        if($order){
            $this->db->order_by($order);
        }
       $this->db->from($table);
       if($id){ 

        if($this->chktblcol($table)=="True"){
            $this->db->where(array('company_id' => $this->session->userdata('comp_id')));
        }

           $this->db->where(array('company_id' => $this->session->userdata('comp_id'), 'id'=>$id));
           $query = $this->db->get(); 
           return $query->row(); 
       }else{ 

        if($this->chktblcol($table)=="True"){
            $this->db->where(array('company_id' => $this->session->userdata('comp_id')));
        }

           $query = $this->db->get(); 
           return $query->result();
       }
        
    }

    public function gquery($type,$table,$id = '',$additional_input='', $clear_fields='', $chkval = ''){

        $data = [];
        $sib = '';

        foreach($_POST as $key => $value){
            if($key != 'password' && $key != 'chk_access'){
                $data[$key] = $this->input->post($key,TRUE);
            }

            if($key=="password" && $this->input->post($key)!=""){
                $data[$key] = getHashedPassword($this->input->post($key));
            }
            
        }

        if($clear_fields){
            $data = [];
        }

        if($additional_input){
            foreach ($additional_input as $key => $value) {
                $data[$key] = $value;
            }
        }

        if($type == 1){ // INSERT

            $data['date_created'] = datetimedb;
            $data['created_by'] = $this->session->usrid; 

            if($this->chktblcol($table)=="True"){
                $data['company_id'] = $this->session->userdata('comp_id'); 
            }   

            $result = $this->db->insert($table, $data);
            $this->tologfile($table,'Insert',$this->db->insert_string($table, $data),$inserted_id);

            $inserted_id = $this->db->insert_id();
            $result = ($this->db->affected_rows() != 1) ? false : true; 

            return array(
                'result'          => $data,
                'query_id'     => $inserted_id 
            );


        }elseif($type == 2){ // UPDATE

            $data['modified_at'] = datetimedb; 

            $this->db->where('id',$id);
            

            if($this->chktblcol($table)=="True"){
                $this->db->where('company_id',$this->session->userdata('comp_id'));
            }

            $result = $this->db->update($table, $data); 

           // echo $this->db->last_query();

            $this->tologfile($table,'Update',$this->db->last_query(),$id);

            $result = ($this->db->affected_rows() != 1) ? false : true;

            

            return array(
                'result'          => $result,
                'query_id'     => $id 
            );

        }elseif($type == 3){ // DELETE

            $data['is_active'] = 3;
            $data['deleted_at'] = datetimedb; 

            if($this->chktblcol($table)=="True"){
                $this->db->where('company_id',$this->session->userdata('comp_id'));
            }

            $this->db->where('id',$id); 
            $this->db->where('company_id',$this->session->userdata('comp_id')); 
            $this->db->update($table,$data); 

            $this->tologfile($table,'Delete',$this->db->last_query(),$id);

            $result = ($this->db->affected_rows() != 1) ? false : true;

           

            return array(
                'result'          => $result,
                'query_id'        => $id 
            );

        }
        elseif($type == 4){ // TOTAL DELETE IN TABLE

            if($additional_input){
                $this->db->where($additional_input);
            }

            if($this->chktblcol($table)=="True"){
                $this->db->where('company_id',$this->session->userdata('comp_id'));
            }

            $this->db->delete($table); 


            $this->tologfile($table,'Full Delete',$this->db->last_query(),'');


            $result = ($this->db->affected_rows() != 1) ? false : true;

            

            return array(
                'result' => $result
            );

        }elseif($type == 5){ // CANCEL OR INACTIVE

            $data['is_active'] = 2;
            $data['modified_at'] = datetimedb; 


            $this->db->where('id',$id); 
        
            if($this->chktblcol($table)=="True"){
                $this->db->where('company_id',$this->session->userdata('comp_id'));
            }

            $this->db->update($table,$data); 

            $this->tologfile($table,'Inactive',$this->db->last_query(),'');

            $result = ($this->db->affected_rows() != 1) ? false : true;


            return array(
                'result'          => $result,
                'query_id'        => $id 
            );

        }

    }

    public function tologfile($table,$event = '',$remakrs='',$tranid=""){
        $data['date_created'] = datetimedb;
        $data['created_by'] = $this->session->usrid;
        $data['machine'] = $_SERVER['REMOTE_ADDR'];
        $data['table'] = $table;
        $data['event'] = $event;
        $data['remarks'] = $remakrs;
        if($tranid){
            $data['trans_id'] = $tranid;
        }
        

        $result = $this->db->insert('logfile', $data);
        $inserted_id = $this->db->insert_id();
        $result = ($this->db->affected_rows() != 1) ? false : true; 

        return array(
            'result'    => $data,
            'query_id'  => $inserted_id 
        );
    }

    public function custom_insert($table,$additional_input=''){

        if($additional_input){
            foreach ($additional_input as $key => $value) {
                $data[$key] = $value;
            }
        }

            $data['date_created'] = datetimedb;
            $data['created_by'] = $this->session->usrid;
            $data['company_id'] = $this->session->userdata('comp_id');

            $result = $this->db->insert($table, $data);
            $inserted_id = $this->db->insert_id();

            $this->tologfile($table,'Insert',$this->db->last_query(),$inserted_id);


            $result = ($this->db->affected_rows() != 1) ? false : true; 


            return array(
                'result'   => $data,
                'query_id' => $inserted_id 
            );


    }

    public function custom_update($table,$additional_input='',$whre=''){

        if($additional_input){
            foreach ($additional_input as $key => $value) {
                $data[$key] = $value;
            }
        }

        $data['modified_at'] = datetimedb; 

        $this->db->where($whre); 
        $this->db->where('company_id',$this->session->userdata('comp_id')); 
        $result = $this->db->update($table, $data); 

        $vxqry = $this->db->last_query();

        $result = ($this->db->affected_rows() != 1) ? false : true;

       

        $getidval = $this->load_core_data($table,'','',$whre);

        $vxqry2= $this->db->last_query();

        $this->tologfile($table,'Update', $vxqry,$getidval[0]->id);


        //get id
        return array(
            'result'  => $vxqry,
            'query_id' => $getidval[0]->id
        );

    }

    
}

?>
