<?php  

class User extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/user_model");
		$this->load->model("admin/account_model");
		$this->load->model("admin/history_model");

	}

	public function index(){
	
	        if(!$this->session->userdata('admin_id'))
			redirect("admin/login");

			$data['title'] = "Admin - All Users";
			
			$page       = $this->uri->segment(4);
			$limit = 30;
			
			if($this->uri->segment(5)=='')
			$total_result = $this->db->count_all('users');
			else $total_result = 1;
			
			
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
			
			if($this->uri->segment(5)=='')
			$data['user_list'] = $this->user_model->getAllUsers($limit,$start_ret);
			else $data['user_list'] = $this->user_model->getSpecificUser($this->uri->segment(5));
			
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
			
			$data['menu'] = "view_user";
			//d($data['user_list'],1);
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
				$data['featured_valid_date'] = $_POST['featured_valid_date'];
						
				$this->user_model->updateUser($data,$_POST['userid']);			
				redirect('admin/user/index/'.$page);
			
			}else{
				//echo 2; exit;
				$data['title'] = "Admin - Edit User";
				$data['current_page'] = $this->uri->segment(5);			
				$data['user_info']    = $this->user_model->getUserDetails($this->uri->segment(4));
				$data['menu'] = "view_user";
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
	
	    $data['menu'] = "view_user";
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
   
   	function accounts()
	{
	    $data['menu'] = "view_user";
		if($this->session->userdata('admin_id'))
		{
			$data['title'] = "Admin - User Accounts";
			$data['current_page'] = $this->uri->segment(5);
			$data['account_info'] = $this->user_model->getUserAccount($this->uri->segment(4));
			$data['userid'] = $this->uri->segment(4);
			
			$this->load->view("admin/user_accounts",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
    function deleteUserAccount()
	{
		if($this->session->userdata('admin_id'))
		{
			$r  = $this->uri->segment(6);
			$page = $this->uri->segment(5);
			
			$this->account_model->deleteUserAccount($this->uri->segment(4));
			$this->history_model->deleteHistoryAccountSpecific($this->uri->segment(4));
			
			redirect('admin/user/accounts/'.$r.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	function changeAccountStatus()
	{
		if($this->session->userdata('admin_id'))
		{
			$uid = $this->uri->segment(7);
			$page = $this->uri->segment(6);
			$status = $this->uri->segment(5);
			$id = $this->uri->segment(4);
			if($status == 'Active')
			{
				$st = "Deactive";
			}
			else
			{
				$st = "Active";
			}
			$this->account_model->changeStatus($id,$st);
			
			redirect('admin/user/accounts/'.$uid.'/'.$page);
		}
		else
		{
		 	redirect("admin/login");
		}
	}
	
	function multideleteUserAccount()
	{
		if($this->session->userdata('admin_id'))
		{
			$page = $this->uri->segment(4);
			$uid  = $this->uri->segment(5);
			$checkbox = $_REQUEST['checkbox'];
			$count = count($checkbox);
			for($i=0; $i<$count; $i++)
			{
				$this->account_model->deleteUserAccount($checkbox[$i]);
				$this->history_model->deleteHistoryAccountSpecific($checkbox[$i]);
			}
			redirect('admin/user/accounts/'.$uid.'/'.$page);
		}
		else
		{
			redirect("admin/login");
		}
	
	}
	
	function accountDetails()
	{
	    $data['menu'] = "view_user";
		if($this->session->userdata('admin_id'))
		{
			$id = $this->uri->segment(4);
			$page = $this->uri->segment(5);
			
			$data['title'] = "Admin - Account Details";
			
			$data['account_info'] = $this->account_model->account_details($id);
			
			$this->load->view("admin/account_details",$data);
		}
		else
		{
			redirect("admin/login");
		}
	}
	
	

}