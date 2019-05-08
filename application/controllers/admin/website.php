<?php  

class Website extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/user_model");
		$this->load->model("admin/tweet_model");
		$this->load->model("admin/account_model");
		$this->load->model("admin/history_model");

	}

	public function index(){
	
	        if(!$this->session->userdata('admin_id'))
			redirect("admin/login");

			$data['title'] = "Admin - All Users";
			
			$status       = $this->uri->segment(4);
			$page       = $this->uri->segment(5);
			$limit = 20;
			$total_result = $this->tweet_model->getAllWebsitesForAdmin(1000,1,$status)->num_rows();//$this->db->count_all('retweets');
			
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
			
			$data['website_list'] = $this->tweet_model->getAllWebsitesForAdmin($limit,$start_ret,$status);
						
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
			
			$data['menu'] = "website";
			
			$this->load->view("admin/website",$data);	   

	}
	
	function edit() 
	{
		if($this->session->userdata('admin_id'))
		{
			
			if($_POST['submit']){
				
				$page = $this->uri->segment(5);
				$status = $this->uri->segment(4);	
				
				$data['tweet'] = $_POST['tweet'];
						
				$this->tweet_model->updateTweet($data,$_POST['tweet_id']);			
				redirect('admin/website/index/'.$status.'/'.$page);
			
			}else{
				
				$data['title'] = "Admin - Edit User";
				$data['status'] = $this->uri->segment(4);
				$data['current_page'] = $this->uri->segment(6);			
				$data['getSpecificTweet'] = $this->tweet_model->getSpecificTweet($this->uri->segment(5));
				$data['menu'] = "retweet";
				
				$this->load->view("admin/edit_retweet",$data);
			}
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
			
			$this->tweet_model->deleteWebsite($this->uri->segment(5));
			
			redirect('admin/website/index/'.$status.'/'.$page);
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
				$this->tweet_model->deleteWebsite($checkbox[$i]);
			}
			redirect("admin/website/index/".$status.'/'.$page);
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
			
			$this->tweet_model->changeWebsiteStatus($this->uri->segment(5));
			
			redirect('admin/website/index/'.$status.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	
	function getFeatured()
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(4);
			
			$this->tweet_model->setFeaturedWebsite($this->uri->segment(5));
			
			redirect('admin/website/index/'.$status.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	

}