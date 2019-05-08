<?php 

class Follow extends Controller 

{
	private $_consumer_key = 'qRVORhDKBTGLqVCN2VG8Q';
    private $_consumer_secret = '1FlEUzZgj1ZVt70YmqIL8XMqNHiBruPvMRbtCJpfOQ';
	
	public function __construct(){

		parent::Controller();
		
		$this->load->library('twitter');
		$this->load->model("admin/account_model");
		$this->load->model("admin/user_model");
		$this->load->model("admin/history_model");
	}

	public function index(){
				
		if(!$this->session->userdata('userid')){
				echo "Sorry! You can't follow before login."; exit;
			}
			
		$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
		if(!$data['accounts']->num_rows){
			echo "Sorry! You do have any twitter profile yet."; exit;
		}
		else{
				
		$account = $data['accounts']->result();	
		//d($account,1);
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
		
		if($this->user_model->checkDupFollower($this->uri->segment(3),$account[0]->account)){
		echo "This is in site error";exit;
		echo $this->uri->segment(2).'###'.$this->uri->segment(3).'###'.$this->session->userdata('credit_points'); exit;
		
		}
		
		$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $account[0]->acc_pwrd_key_twt, $account[0]->acc_secret_twt);
		$result = $this->twitter->post("friendships/create", array("user_id" => $this->uri->segment(2)));
		
		//d($result->following,1);
		if($result->following == 1){

			
				
				$query = $this->account_model->getAccountDetail($this->uri->segment(3));
				
				$arr = $this->user_model->getUserDetails($query[0]->userid)->result();
				//d($arr[0],1);
				if($arr[0]->credit_points >= $query[0]->offered_credit){
					$updata['credit_points'] = $this->session->userdata('credit_points') + $query[0]->offered_credit;
					$updata2['credit_points'] = $arr[0]->credit_points - $query[0]->offered_credit;
					$sum_user1_credit = $updata2['credit_points'];					
					$sum_user2_credit = $updata['credit_points'];					
					$sum_bonus_credit = $query[0]->offered_credit;
					$this->user_model->updateUser($updata2,$query[0]->userid);
					$this->user_model->updateUser($updata,$this->session->userdata('userid'));
				}else{
					$sum_user1_credit = $arr[0]->credit_points;					
					$sum_user2_credit = $this->session->userdata('credit_points');					
					$sum_bonus_credit = 0;
					}
					$sumData['user1']         = $query[0]->userid;
					$sumData['user2']         = $this->session->userdata('userid');
					$sumData['activity']      = 'follow';
					$sumData['text']          = $query[0]->account;
					$sumData['user1_credit']  = $sum_user1_credit;
					$sumData['user2_credit']  = $sum_user2_credit;
					$sumData['bonus_credit']  = $sum_bonus_credit;
					$sumData['timestamp']     = strtotime("now");
					
					$this->history_model->newSummary($sumData);	
				
					$inData['mimic']        = $query[0]->account;
	
					$inData['mimic_image']  = $query[0]->profile_image;
	
					$inData['userid']       = $this->session->userdata('userid');
	
					$inData['acc_name']     = $account[0]->account;
					
					$this->history_model->newHistory($inData);
					
					$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
					$this->session->set_userdata($user_details);
				
					if(0){
						echo $this->uri->segment(2).' #F#F# '.$this->uri->segment(3).' #F#F# '. ($this->session->userdata('credit_points')).' #F#F# Protected user, follow request sent'; exit;
					}else{
						echo $this->uri->segment(2).' #F#F# '.$this->uri->segment(3).' #F#F# '. ($this->session->userdata('credit_points')); exit;
					}
					}
					else if(strstr($result->error, 'is already on your list')){
					echo "Sorry! This twitter user '".$this->uri->segment(3)."' is already on your list"; exit;
					}
					else{
					echo 'Error: '.$result->error; exit;
					}
		
		}

	}
}
?>