<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

class Admin_model extends Model {

		public function __construct(){

			parent::Model();

		}
		
		public function getAdminDetails($admin_id){
			
			return $this->db->get_where('admin', array('admin_id' => $admin_id));
		}
		
		public function update_admin_username($data2){
			$data = array(
						  	'adminname' => $data2['username']
						 );
			$this->db->where('admin_id', $this->session->userdata('admin_id'));
			$this->db->update('admin',$data);
			return 1;
		}
		
}