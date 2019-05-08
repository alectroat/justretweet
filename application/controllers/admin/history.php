<?php 

class History extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/user_model");

	}

	public function index(){
	
	        if(!$this->session->userdata('admin_id'))
			redirect("admin/login");

			$data['title'] = "Admin - All Users";
			
			$page       = $this->uri->segment(4);
			$limit = 30;
			$total_result = $this->db->count_all('users');
			
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
			
			$data['user_list'] = $this->user_model->getAllUsers($limit,$start_ret);
			
			$this->load->view("admin/view_user",$data);	   

	}
	
	function edit() 
	{
		if($this->session->userdata('admin_id'))
		{
			
			if($_POST['submit']){
				//echo '1';exit;
				$page = $this->uri->segment(4);	
				
				$data['status']     = $_POST['status'];
				$data['isFeatured'] = $_POST['isFeatured'];
				$data['credit_points'] = $_POST['credit_points'];
						
				$this->user_model->updateUser($data);			
				redirect('admin/user/index/'.$page);
			
			}else{
				//echo 2; exit;
				$data['title'] = "Admin - Edit User";
				$data['current_page'] = $this->uri->segment(5);			
				$data['user_info']    = $this->user_model->getUserDetails($this->uri->segment(4));
				
				$this->load->view("admin/edit_user",$data);
			}
		}
		else
		{
			redirect("admin/login");
		}
    }
	
	function detail() 
	{
		if($this->session->userdata('admin_id'))
		{
			$data['page'] = $this->uri->segment(5);
			
			$data['user_info'] = $this->user_model->getUserDetails($this->uri->segment(4));
			
			$this->load->view("admin/detail_user",$data);
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
			$page = $this->uri->segment(5);
			
			$this->user_model->deleteUser($this->uri->segment(4));
			
			redirect('admin/user/index/'.$page);
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
				$this->user_model->deleteUser($checkbox[$i]);
			}
			redirect("admin/user/index/".$page);
		}
		else
		{
			redirect("admin/login");
		}
   }


}