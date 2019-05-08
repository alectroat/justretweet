<?php 

class Profile extends Controller 
{
	
	private $_data = array();
	
	public function __construct(){

		parent::Controller();
		$this->load->library('twitter');
		$this->load->model("admin/account_model");
		$this->load->model("admin/tweet_model");
		$this->load->model("admin/user_model");
		$this->load->model("admin/history_model");
		$this->_data['menu'] = 'home';
		$this->_data['title'] = 'welcome to the Just Retweet site';
		if(!$this->session->userdata('userid')){
			
				redirect('main');
		}
		
	}

	public function index()
	{	
		if($this->uri->segment(2)){		
			
			setcookie("r_id", $this->uri->segment(2), time()+3600*240, "/");
		}
		
		if($_COOKIE['user_id']!=''){
			$user_details = $this->user_model->getUserDetails($_COOKIE['user_id'])->row_array();
			if($user_details){
				$this->session->set_userdata($user_details);
			}
		}
		$data['sites'] = $this->tweet_model->getTopSites();
		$data['featured_site'] = $this->tweet_model->getFeaturedWebsite();
				
		if($this->session->userdata('userid'))
		{
		
			$data['retweets'] = $this->tweet_model->getAllRetweets2($this->session->userdata('userid'));		
			$data['follower'] = $this->tweet_model->getSpecificUserFollower($this->session->userdata('userid'));		
			$data['follow_list'] = $this->tweet_model->wannaFollow($this->session->userdata('userid'));
			$data['unfollow_list'] = $this->tweet_model->wannaUnfollow($this->session->userdata('userid'));
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			$accounts = $data['accounts']->result();
			$arr =  $this->history_model->getHistoryMimicAccountSpecific($accounts[0]->account);
			
			$data['account'] = $accounts[0]->account;
			
			if(count($arr))
				{
				$i = 0;
				foreach($arr as $ret)
					{
					$array[$i] = $ret->mimic;
					$i++;
					}
				$data['mimic'] = $array;	
				}
			else
				{
				$data['mimic'] = array();
				}
			
		}
		
		else
			{
			$data['mimic'] = array();
			}
		
		$data['adds'] = $this->tweet_model->getAdds();
		//d($data['adds'],1);
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		$data['latest_users'] = $this->tweet_model->getLatestUsers();
				
		$data['menu'] = 'main';
		
		$this->load->view('profile',$data);
	}
	

}
?>