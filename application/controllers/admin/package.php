<?php 

class Package extends Controller 

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
			$data['title'] = "Admin - Package";
			
			$page       = $this->uri->segment(4);
			$limit = 30;
			$total_result = $this->db->count_all('package');
			
			$total_page = ceil($total_result/$limit);
			if($page=='' || $page <= 1 ){
				$page = 1;
			}
			elseif($page > $total_page)
			{
				$page = $page -1;
			}
			else
			{
				$page = $page;
			}
			
			$start_ret = ($page-1)*$limit+1;
			$end_ret   = $page*$limit;
			if($end_ret > $total_result){
				$end_ret = $total_result;
			}
				
			$data['total_results'] = $total_result;
			$data['limit']         = $limit;
			$data['total_page']    = $total_page;
			$data['start']         = $start_ret-1;
			$data['end_result']    = $end_ret;
			$data['current_page']  = $page;
			
			$data['package_list'] = $this->package_model->getPackage($limit,$start_ret);
			$data['menu'] = "package";
			$this->load->view("admin/package",$data);	   
		}
		else
		{
			redirect("admin/login");
		}
    }
	
	function delete()
	{
		if($this->session->userdata('admin_id'))
		{
			$package_id = $this->uri->segment(4);
			$page       = $this->uri->segment(5);
			
			$this->package_model->deletePackage($package_id);
			redirect("admin/package/index/".$page);
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
			$data['menu'] = "package";
			$this->load->view("admin/package_add",$data);
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
			
			$rules['package_name']           = "required|xss_clean";
			$rules['package_type']           = "required|xss_clean";
			$rules['package_value']          = "required|xss_clean";
			$this->validation->set_rules($rules);
		
			
			$fields['package_name']          = 'Package Name';
			$fields['package_type']          = 'Package Type';
			$fields['package_value']         = 'Package Value';
			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Package';
				$data['username'] = $_REQUEST['username'];
				$data['success'] = "";
					
					
				$this->load->view("admin/package_add", $data);
			}
			else
			{
				$sus = $this->package_model->save_package($_POST);
					
				if($sus == 1)
				{
					$data['title'] = 'Admin - Package';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully inserted.</font>";
					$this->load->view("admin/package_add", $data);
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
			$package_id = $this->uri->segment(4);
			$page = $this->uri->segment(5);
			$data['title'] = "Admin - Package";
			$data['current_page'] = $this->uri->segment(5);	
			$data['package_info'] = $this->package_model->editPackage($package_id);
			
			$this->load->view("admin/package_edit",$data);
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
			
			$this->package_model->updatePackage($_POST);
			
			redirect("admin/package/index/".$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
		
}