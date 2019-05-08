<?php 

class Main extends Controller 
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
		
	}

	public function index(){
			
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
		
		$this->load->view('index',$data);
	}
	
	
	public function follow(){
	
	    $account = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'))->result();	
		$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $account[0]->acc_pwrd_key_twt, $account[0]->acc_secret_twt);
		
		$result = $this->twitter->post("friendships/create", array("screen_name" => $this->uri->segment(3)));
	
		if($result->following || $result->protected || $result->error == "Could not follow user: You've already requested to follow wendyevelynwick."){
		          
			 if($result->protected || $result->error == "Could not follow user: You've already requested to follow wendyevelynwick."){
				echo $this->uri->segment(3).'###'.' #F#F# Protected user, follow request sent'; exit;
			}else{
			    $this->tweet_model->deleteFromFollowList($this->session->userdata('userid'),$this->uri->segment(4));
				$query = $this->account_model->getAccountDetail($this->uri->segment(3));
				$arr = $this->user_model->getUserDetails($query[0]->userid)->result();
				
				if($arr[0]->credit_points >= $query[0]->offered_credit){
					
					$updata['credit_points'] = $this->session->userdata('credit_points') + $query[0]->offered_credit;
					
					$updata2['credit_points'] = $arr[0]->credit_points - $query[0]->offered_credit;
				
					$this->user_model->updateUser($updata2,$query[0]->userid);
					$this->user_model->updateUser($updata,$this->session->userdata('userid'));
				}	
						
				
				$inData['mimic']        = $query[0]->account;
				$inData['mimic_image']  = $query[0]->profile_image;
				$inData['userid']       = $this->session->userdata('userid');
				$inData['acc_name']     = $account[0]->account;
				
				$this->history_model->newHistory($inData);
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				echo $this->uri->segment(3).'###'.$this->session->userdata('credit_points'); exit;
			}
		
		}
		else{				
				echo 'Error: '.$result->error; exit;
			}
	
		}
	
	public function unfollow(){
	
	    $account = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'))->result();	
		$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $account[0]->acc_pwrd_key_twt, $account[0]->acc_secret_twt);
		
		$result = $this->twitter->post("friendships/destroy", array("screen_name" => $this->uri->segment(3)));
		$this->tweet_model->deleteFromUnfollowList($this->session->userdata('userid'),$this->uri->segment(4));
				echo $this->uri->segment(3).'###'; exit;
			
				echo 'Error: '.$result->error; exit;
		
		}
		
		
		
		public function retweet(){
	
	    $user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
	
	    $WhoseTweet = $this->tweet_model->getWhoseTweet($this->uri->segment(3));		
	
	    $data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));	 
       	$account = $data['accounts']->result();		
		$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $account[0]->acc_pwrd_key_twt, $account[0]->acc_secret_twt);
		
		$result = $this->twitter->post("statuses/update",array("status" => 'RT @'.$WhoseTweet[0]->account.' '.$WhoseTweet[0]->tweet));
		
								
				if($result->error=='' and ($WhoseTweet[0]->total_offered_credit >= $WhoseTweet[0]->credit_per_tweet)){	
					
					$updata['credit_points'] = $this->session->userdata('credit_points') + $WhoseTweet[0]->credit_per_tweet;
					
					$updata2['total_offered_credit'] = $WhoseTweet[0]->total_offered_credit - $WhoseTweet[0]->credit_per_tweet;
				
					$this->tweet_model->updateRetweet($updata2,$this->uri->segment(3));
					$this->user_model->updateUser($updata,$this->session->userdata('userid'));
					
					
					$inData['retweet_id']   = $this->uri->segment(3);
					$inData['userid']  = $this->session->userdata('userid');
					$inData['credit']  = $WhoseTweet[0]->credit_per_tweet;
					
					$this->tweet_model->insertRetweetHistory($inData);
					
					$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		            $this->session->set_userdata($user_details);
					
					echo '1#'.$this->uri->segment(3).'#'.$this->session->userdata('credit_points');
				}else echo '0#'.$this->uri->segment(3).'#'.$this->session->userdata('credit_points');
	   

	}
	
	public function skip(){
	
	$data['userid'] = $this->session->userdata('userid');
	$data['retweet_id'] = $this->uri->segment(3);
	$this->tweet_model->insertRetweetSkip($data);
	
	echo $this->uri->segment(3);
	
	}
		
	
	function array_uniquecolumn($arr)
	{
		$rows   = sizeof($arr);
		$columns = sizeof($arr[0]);
	   
		$columnkeys = array_keys($arr[0]);
	   
	
		for($i=0; $i<$columns; $i++)
		{
			for($j=0;$j<$rows;$j++)
			{
				for($k = $j+1; $k<$rows; $k++)
				{
					if($arr[$j][$columnkeys[$i]] == $arr[$k][$columnkeys[$i]]){
						unset($arr[$k]);
					}
						//$arr[$k][$columnkeys[$i]] = "";       
				}
			}
	   
		}
	
	return ($arr);
	
	}
	
	function remove_dup($matriz) {
		$aux_ini=array();
		$entrega=array();
		for($n=0;$n<count($matriz);$n++)
		{
			$aux_ini[]=serialize($matriz[$n]);
		}
		$mat=array_unique($aux_ini);
		for($n=0;$n<count($matriz);$n++)
		{
		   
				$entrega[]=unserialize($mat[$n]);
		   
		}
		return $entrega;
	} 
	
}
?>