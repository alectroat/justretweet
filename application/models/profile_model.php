<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

class Profile_model extends Model {

		

		function __construct(){

			parent::Model();

		}
		
		public function updateuser(){

		  return	$qry = $this->db->query("UPDATE user SET position='".$_REQUEST['position']."', draw_no='".$_REQUEST['draw_no']."',amount='".$_REQUEST['amount']."',bondnumber='".$_REQUEST['bond_no']."' where id= '".$result_id."'");

	    }
		
		function postmessage()
		{
			$array = array();
			$array['profile_id'] 	= $_POST['msgid'];
			$array['msg_text'] 		= $_POST['message'];
			$format			 		= $_POST['date']." ".$_POST['hours'].":".$_POST['minute'].":"."00";
			$array['posttime']		=strtotime($format);
		
			$this->db->insert('message',$array);
			return mysql_insert_id();
		
		}

}

	



