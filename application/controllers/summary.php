<?php 

class Summary extends Controller 

{

    private $_consumer_key = 'qRVORhDKBTGLqVCN2VG8Q';
    private $_consumer_secret = '1FlEUzZgj1ZVt70YmqIL8XMqNHiBruPvMRbtCJpfOQ';
	
	public function __construct(){
		
		
		
		parent::Controller();
		$this->load->library('twitter');
		$this->load->model("admin/account_model");
		$this->load->model("admin/tweet_model");
		$this->load->model("admin/user_model");
		$this->load->model("admin/history_model");
		
		if(!$this->session->userdata('userid')){
			
			redirect('main');
		}
		
	}

	public function index(){
				
		/***********************************************************************/
		    $page = $this->uri->segment(3);
			$limit = 2;
			
			switch($this->uri->segment(2)){
			
			case 'follow':
						  $total_result = $this->history_model->getSpecificSummaryCount($this->session->userdata('userid'),'follow','follow')->num_rows();
						  break;
			case 'retweet':
						  $total_result = $this->history_model->getSpecificSummaryCount($this->session->userdata('userid'),'retweet','xretweet')->num_rows();
						  break;				
			
			default:
				
						  $total_result = $this->history_model->getAllSummarycount($this->session->userdata('userid'))->num_rows();
						  break;		
			}
				
			
						
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
		
		/***********************************************************************/		
		
				
		$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'))->result();
		//d($data['accounts'],1);
		switch($this->uri->segment(2)){
		
		case 'follow':
		              $demo_summary = $this->history_model->getSpecificSummary($this->session->userdata('userid'),'follow','follow',$limit,$start_ret-1);
					  $data['submenu'] = 'follow';
					  break;
		case 'retweet':
		              $demo_summary = $this->history_model->getSpecificSummary($this->session->userdata('userid'),'retweet','xretweet',$limit,$start_ret-1);
					  $data['submenu'] = 'retweet';
					  break;				
		
		default:
					  $demo_summary = $this->history_model->getAllSummary($this->session->userdata('userid'),$limit,$start_ret-1);
					  $data['submenu'] = 'all';
					  break;		
		}
		
		//$demo_summary = $this->history_model->getAllSummary($this->session->userdata('userid'),$limit,$start_ret-1);
		//$demo_summary = $this->history_model->getSpecificSummary($this->session->userdata('userid'),'retweet','xretweet',$limit,$start_ret-1);
		
				
		$index=-1;
		foreach($demo_summary as $list){
		
		$query1 = $this->account_model->getUserSpecificAccount($list->user1)->result();
		$query2 = $this->account_model->getUserSpecificAccount($list->user2)->result();
					
		$summary[++$index]->user1=$list->user1;
		$summary[$index]->account1=$query1[0]->account;
		$summary[$index]->profile_image1=$query1[0]->profile_image;
		$summary[$index]->user2=$list->user2;
		$summary[$index]->account2=$query2[0]->account;
		$summary[$index]->profile_image2=$query2[0]->profile_image;
		$summary[$index]->activity=$list->activity;
		$summary[$index]->text=$list->text;
		$summary[$index]->user1_credit=$list->user1_credit;
		$summary[$index]->user2_credit=$list->user2_credit;
		$summary[$index]->offered_credit=$list->offered_credit;
		$summary[$index]->bonus_credit=$list->bonus_credit;
		$summary[$index]->entry_date=$list->entry_date;		
		
		}
		//$data['spam_report'] = $this->tweet_model->getSpamReport($this->session->userdata('userid'));				
		$data['summary'] = $summary; 
		//$data['submenu'] = 'all';			
		$data['menu'] = 'summary';
		
		$this->load->view('summary',$data);
	}
	
	
}
?>