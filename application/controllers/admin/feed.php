<?php 

class Feed extends Controller 

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

			$data['title'] = "Admin - Blogs";
			
			$blog_id = $this->uri->segment(3);
			$status       = $this->uri->segment(4);
			$page       = $this->uri->segment(5);
			$limit = 20;
			$total_result = $this->tweet_model->getFeedsForAdmin($blog_id,1000,1,$status)->num_rows();//$this->db->count_all('retweets');
			
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
			$data['blog_id']       = $blog_id;
			
			if($status=='')$status='All';
			$data['status']  = $status;
			
			$data['feed_list'] = $this->tweet_model->getFeedsForAdmin($blog_id,$limit,$start_ret,$status);
			
			//echo '<pre>';
			//print_r($data['retweet_list']);exit;
			
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
			
			$data['menu'] = "blog";
			
			$this->load->view("admin/feed",$data);	   

	}
	
	
	function delete() 
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(5);
			
			$this->tweet_model->deleteFeed($this->uri->segment(7));
			
			redirect('admin/feed/'.$this->uri->segment(4).'/'.$status.'/'.$page);
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
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(5);
			$checkbox = $_REQUEST['checkbox'];
			$count = count($checkbox);
			for($i=0; $i<$count; $i++)
			{
				$this->tweet_model->deleteFeed($checkbox[$i]);
			}
			redirect('admin/feed/'.$this->uri->segment(4).'/'.$status.'/'.$page);
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
			$status = $this->uri->segment(5);
			
			$this->tweet_model->changeFeedStatus($this->uri->segment(7));
			
			redirect('admin/feed/'.$this->uri->segment(4).'/'.$status.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	

}

?>