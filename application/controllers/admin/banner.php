<?php  

class Banner extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/user_model");
		$this->load->model("admin/tweet_model");
		$this->load->model("admin/account_model");
		$this->load->model("admin/history_model");
		$this->load->model("admin/package_model");
		$this->load->library(array('validation','pagination'));

	}

	public function index(){
	
	        if(!$this->session->userdata('admin_id'))
			redirect("admin/login");

			$data['title'] = "Admin - All Users";
			
			$status       = $this->uri->segment(4);
			$page       = $this->uri->segment(5);
			$limit = 20;
			$total_result = $this->tweet_model->getAllBanners(1000,1,$status)->num_rows();//$this->db->count_all('retweets');
			
			$total_page = ceil($total_result/$limit);
			if($page=='' || $page <= 1 ){
				$page = 1;
			}
			elseif($page > $total_page)
			{
				$page = $total_page;
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
			
			if($status=='')$status='All';
			$data['status']  = $status;
			
			$data['banner_list'] = $this->tweet_model->getAllBanners($limit,$start_ret,$status);
						
			$res = $this->user_model->get_ip();
			foreach($res->result() as $ret)
			{
				$logged_ip   = $ret->logged_ip;
				$logged_time = date("jS M,Y g:ia", strtotime($ret->logged_time));
				$admin_id    = $ret->admin_id;
			}
			$data['logged_ip']   = $logged_ip;
			$data['logged_time'] = $logged_time;
			$data['admin_user']  = $this->user_model->get_adminUser($admin_id);
			
			$data['menu'] = "banner";
			
			$this->load->view("admin/banner",$data);	   

	}
	
	public function add(){
	
	     if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin - Banner";
			$data['menu'] = "banner";
			$this->load->view("admin/banner_add",$data);
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
			$rules['banner_url']             = "required|xss_clean";
			$this->validation->set_rules($rules);
		
			$fields['banner_url']          = 'Banner Url';
			$this->validation->set_fields($fields);
				
				
			if ($this->validation->run() == FALSE)
			{
				$data['title'] = 'Admin - Package';
				$data['error'] = "";
				if(!$_FILES['banner_img']['name'])
				$data['error'] = "The Banner img field is required.";
					
				$this->load->view("admin/banner_add", $data);
			}
			else
			{
				
				if($_FILES['banner_img']['name']){
				
				$sus = $this->package_model->save_banner($_FILES['banner_img']['name'],$_REQUEST['banner_url']);
				$file_name =$_FILES['banner_img']['name'];
				$distination = "asset/images/upload/img_".$sus.'_'.$file_name;
				move_uploaded_file($_FILES['banner_img']['tmp_name'], $distination);
					
				if($sus)
				{
					$data['title'] = 'Admin - Banner';
					$data['success'] = "<font style='color:#00FF00; font-weight:bold; font-size:14px;'>Your information has been successfully inserted.</font>";
					$this->load->view("admin/banner_add", $data);
				}
				}
				else{
				
				$data['title'] = 'Admin - Package';
				$data['error'] = "";
				if(!$_FILES['banner_img']['name'])
				$data['error'] = "The Banner img field is required.";
					
				$this->load->view("admin/banner_add", $data);
				
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
			    $data['title'] = "Admin - Edit Banner";
				$data['status'] = $this->uri->segment(4);
				$data['current_page'] = $this->uri->segment(6);			
				$data['getSpecificBanner'] = $this->tweet_model->getSpecificBanner($this->uri->segment(5));
				$data['menu'] = "banner";
				
				$this->load->view("admin/banner_edit",$data);
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
			    $page = $this->uri->segment(5);
				$status = $this->uri->segment(4);	
				
				$banner_id = $_POST['banner_id'];
				
				if($_FILES['banner_img']['name']){
				$getSpecificBanner = $this->tweet_model->getSpecificBanner($banner_id);
				unlink("asset/images/upload/img_".$banner_id.'_'.$getSpecificBanner[0]->banner_img);
				$file_name =$_FILES['banner_img']['name'];
				$distination = "asset/images/upload/img_".$banner_id.'_'.$file_name;
				move_uploaded_file($_FILES['banner_img']['tmp_name'], $distination);				
				$data['banner_img'] = $_FILES['banner_img']['name'];
				}
				
				$data['banner_link'] = $_POST['banner_url'];
				if($_POST['status']=='Active')
				$data['status'] = 1;
				else $data['status'] = 0;
						
				$this->tweet_model->updateBanner($data,$banner_id);			
				redirect('admin/banner/index/'.$status.'/'.$page);
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
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(4);
			
			$this->tweet_model->deleteBanner($this->uri->segment(5));
			
			redirect('admin/banner/index/'.$status.'/'.$page);
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
			$page = $this->uri->segment(5);
			$status = $this->uri->segment(4);
			$checkbox = $_REQUEST['checkbox'];
			$count = count($checkbox);
			for($i=0; $i<$count; $i++)
			{
				$this->tweet_model->deleteBanner($checkbox[$i]);
			}
			redirect("admin/banner/index/".$status.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
    }
   
  	
	function status()
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(4);
			
			$this->tweet_model->changeBannerStatus($this->uri->segment(5));
			
			redirect('admin/banner/index/'.$status.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
		
}