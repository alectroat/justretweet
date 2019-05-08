<?php 

class Changepassword extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/changepassword_model");
		$this->load->library(array('validation','pagination'));
	}
	
	function index() 
	{
		if($this->session->userdata('admin_id'))
		{
				//echo 2; exit;
				$data['title'] = "Admin - Change Password";
				//$data['admin_info']    = $this->change_password_model->getUserDetails($this->uri->segment(4));
				$data['menu'] = "admin_profile";
				
				$this->load->view("admin/change_password",$data);
				
		}
		else
		{
			redirect("admin/login");
		}
    }
	
	function updatepassword(){
	
	    $data['menu'] = "admin_profile";
	
		if($this->session->userdata('admin_id'))
		{
			$rules['current_password']       = "required|xss_clean|callback_verify_currentpassword";
			$rules['new_password']           = "required|xss_clean";
			$rules['confirm_password']       = "required|matches[new_password]";
			$this->validation->set_rules($rules);
		
			$fields['current_password']      = 'Current Password';
			$fields['new_password']          = 'New Password';
			$fields['confirm_password']      = 'Confirm Password';
			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Change Password';
				$data['current_password'] = $_REQUEST['current_password'];
				$data['success'] = "";
					
					
				$this->load->view("admin/change_password", $data);
			}
			else
			{
				$sus = $this->changepassword_model->update_admin_password($_POST);
					
				if($sus == 1)
				{
					$data['title'] = 'Admin - Change Password';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
					$this->load->view("admin/change_password", $data);
				}
			}

		}
		else
		{
			redirect("admin/login");
		}
  }
  function verify_currentpassword($str){
	$email =  $this->db->get_where('admin', array('password' => md5($str)));
        if($email->num_rows() <= 0) {
			$this->validation->set_message('verify_currentpassword', 'Current password is not match.');
			return false;
        } else {
            return true;
        }
    }  
	

}