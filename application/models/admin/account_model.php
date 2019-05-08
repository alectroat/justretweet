<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Account_model extends Model {

		

		public function __construct(){

			parent::Model();

		}
		
		public function getAllAccount($limit,$offset){

			$offset = $offset -1;
			$this->db->order_by("id", "desc");
			$res = $this->db->get_where('accounts',array(),$limit,$offset);
			
			return $res;	   

		}
		
		public function newAccount($data){

			return $this->db->insert("accounts",$data);	

		}
		
		public function updateAccount($data){

			return $this->db->update("accounts",$data,array("id" => $_POST['id']));	  

		}

		public function deleteAccount($id){

			return $this->db->delete("accounts",array("id" => $id));			   

		}

		public function getAccountDetails($id){

		    return $query = $this->db->get_where('accounts',array('id' => $id));

		    //return $query->row();

	    }

		public function total_accounts(){

			$query = $this->db->get('accounts');

		    return $query->num_rows();   

		}
		
		public function deleteUserAccount($id){
			
			return $this->db->delete("accounts",array("account" => $id));
		}
		
		public function changeStatus($id,$st){
		//echo $st;exit;
			$data = array(
						'status' => $st
						 );
			return $this->db->update("accounts",$data,array('id' => $id));
		}
		
		public function account_details($id){
			
			return $this->db->get_where("accounts",array('id' => $id));
		}
		
		public function getTwitterUserDetailsByTwitterid($twitter_id){
           $query = $this->db->query(
		                               $sql=
		   								  "SELECT *
										   FROM   accounts
										   WHERE  id = '$twitter_id'
										  "
								     );
			$results = $query->row();
			return !empty($results) ? $results: false;
		   
		}
				
		public function getUserSpecificAccount($userid){
			
			return $this->db->get_where("accounts",array("userid" => $userid));
		}
  		
		public function getAccountDetail($account){
			
			$res = $this->db->get_where("accounts",array("account" => $account));
			
			return $res->result();
		}
		
		public function deleteAccountUserSpecific($userid){
			
			return $this->db->delete("accounts",array("userid" => $userid));
		}		
		
		public function getAccountName()
		{
			return $this->db->get_where("payaccount");
		}

}