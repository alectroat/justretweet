<?php 

class Admin extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/admin_model");
		$this->load->library(array('validation','pagination'));
	}
	
	function index() 
	{
		if($this->session->userdata('admin_id'))
		{
				$data['title']      = "Admin - Admin Profile";
				$data['admin_info'] = $this->admin_model->getAdminDetails($this->session->userdata('admin_id'));
				$data['menu'] = "admin_profile";
				$this->load->view("admin/admin_profile",$data);
				
		}
		else
		{
			redirect("admin/login");
		}
    }
	
	function changeUsername()
	{
		if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin - Change Username";
			$data['menu'] = "admin_profile";
			
			$this->load->view("admin/change_username",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function updateUsername()
	{
		if($this->session->userdata('admin_id'))
		{
			$rules['username']           = "required|xss_clean";
			$this->validation->set_rules($rules);
		
			$fields['username']          = 'Username';
			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Change Username';
				$data['username'] = $_REQUEST['username'];
				$data['success'] = "";
					
					
				$this->load->view("admin/change_username", $data);
			}
			else
			{
				$sus = $this->admin_model->update_admin_username($_POST);
					
				if($sus == 1)
				{
					$data['title'] = 'Admin - Change Username';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully updated.</font>";
					$this->load->view("admin/change_username", $data);
				}
			}
		}
		else
		{
			redirect("admin/login");
		}
	}
	
}