<?php 

class Tweet extends Controller 

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
					
		$data['retweets'] = $this->tweet_model->getAllRetweets($this->session->userdata('userid'));
		
		$data['follower'] = $this->tweet_model->getSpecificUserFollower($this->session->userdata('userid'));
				
		$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
		$data['menu'] = 'tweet';
		
		$this->load->view('tweet',$data);
	}
	
	public function retweet(){
	
	    $user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
	
	    $WhoseTweet = $this->tweet_model->getWhoseTweet($this->uri->segment(3));		
		//d($WhoseTweet,1);
	    $data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));	 
       	$account = $data['accounts']->result();
		
		$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $account[0]->acc_pwrd_key_twt, $account[0]->acc_secret_twt);
		
		$result = $this->twitter->post("statuses/update",array("status" => 'RT @'.$WhoseTweet[0]->account.' '.$WhoseTweet[0]->tweet));
		//d($result,1);
								
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
	
}
?>