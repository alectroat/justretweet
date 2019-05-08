<?php 

class Setting extends Controller 

{
	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/package_model");
		$this->load->library(array('validation','pagination'));
	}
	
	function index() 
	{
		if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin -PayPall Setting";
			$data['acount_list'] = $this->package_model->getAccount($limit,$start_ret);
			
			$data['menu'] = "setting";
			$this->load->view("admin/setting",$data);	   
		}
		else
		{
			redirect("admin/login");
		}
    }
	
	function signupmessage()
	{
		$data['title'] = "Admin -PayPall Setting";
		$data['signup_msg'] = $this->package_model->getSignUpMsg();
			
		$data['menu'] = "setting";
		$this->load->view("admin/signupmsg",$data);
	}
	
	function delete()
	{
		if($this->session->userdata('admin_id'))
		{
			$pay_acc_id = $this->uri->segment(4);
			
			
			$this->package_model->deleteAccount($pay_acc_id);
			redirect("admin/setting/index/");
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function multidelete()
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(4);
			$checkbox = $_REQUEST['checkbox'];
			$count = count($checkbox);
			for($i=0; $i<$count; $i++)
			{
				$this->package_model->mdeletePackage($checkbox[$i]);
			}
			redirect("admin/package/index/".$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function add()
	{
		if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin - Package";
			$data['menu'] = "setting";
			$this->load->view("admin/account_add",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function addsignmsg()
	{
		if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin - Setting";
			$data['menu'] = "setting";
			$this->load->view("admin/signmsg_add",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function save()
	{
		if($this->session->userdata('admin_id'))
		{
			$rules['account_name']           = "required|xss_clean|valid_email";
			
			
			$this->validation->set_rules($rules);
		
			$fields['account_name']          = 'Account Name';
			

			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Setting';
				$data['success'] = "";
					
					
				$this->load->view("admin/account_add", $data);
			}
			else
			{
				$sus = $this->package_model->save_account($_POST);
					
				if($sus == 1)
				{
					$data['title'] = 'Admin - Setting';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully inserted.</font>";
					$this->load->view("admin/account_add", $data);
				}
			}
			
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function savemsg()
	{
		if($this->session->userdata('admin_id'))
		{
			$rules['message_name']           = "required|xss_clean";
			
			
			$this->validation->set_rules($rules);
		
			$fields['message_name']          = 'Message';
			

			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Setting';
				$data['success'] = "";
					
					
				$this->load->view("admin/signmsg_add", $data);
			}
			else
			{
				$sus = $this->package_model->savemsg_account($_POST);
					
				if($sus == 1)
				{
					$data['title'] = 'Admin - Setting';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully inserted.</font>";
					$this->load->view("admin/signmsg_add", $data);
				}
			}
			
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	
	function edit()
	{
		if($this->session->userdata('admin_id'))
		{
			$pay_acc_id = $this->uri->segment(4);
			//$page = $this->uri->segment(5);
			$data['title'] = "Admin - Setting";
			//$data['current_page'] = $this->uri->segment(5);	
			$data['account_info'] = $this->package_model->editAccount($pay_acc_id);
			
			$this->load->view("admin/account_edit",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function update()
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(4);
			
			$this->package_model->updateSetting($_POST);
			
			redirect("admin/package/index/".$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
		
}