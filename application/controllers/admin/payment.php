<?php 

class Payment extends Controller 

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
			$data['title'] = "Admin - Payment History";
			
			$page       = $this->uri->segment(4);
			$limit = 30;
			$total_result = $this->db->count_all('payment_history');
			
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
			
			$data['payment_history'] = $this->package_model->getPaymentHistory($limit,$start_ret);
			$data['menu'] = "package";
			
			$this->load->view("admin/payments",$data);	   
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
			$pay_id = $this->uri->segment(4);
			$page       = $this->uri->segment(5);
			
			$this->package_model->deletePaymentHistory($pay_id);
			redirect("admin/payment/index/".$page);
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
				$this->package_model->deletePaymentHistory($checkbox[$i]);
			}
			redirect("admin/payment/index/".$page);
		}
		else
		{
			redirect("admin/login");
		}
	}
		
}