<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    class Common extends Model {
		
		public function __construct(){
			parent::Model();
		}
		public function getAllBranches(){
				   
				   
		}
		public function newBranch()
		{	
		}
		
		public function updateBranch(){	   
		  
		}
		
		public function deleteBranch(){
		   
		}
		public function getCountryList(){
		    $query = $this->db->get('country');
		    return $query->result();
		}				
    }