<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	

class Changepassword_model extends Model {

		public function __construct(){

			parent::Model();

		}
		
		public function update_admin_password($data2){
			$data = array(
						  'password '  => md5($data2['new_password'])
						 );
			$this->db->where('admin_id', $this->session->userdata('admin_id'));
			$this->db->update('admin',$data);
			return 1;
		}
		
}