<?php 
class Setting extends Controller 
{

	public function __construct(){

		parent::Controller();
		
		if(!$this->session->userdata('userid')){
			
				redirect('main');
			
			}

		$this->load->model("admin/user_model");
		$this->load->model("admin/account_model");
		$this->load->model("admin/history_model");
		$this->load->model("admin/tweet_model");
		$this->load->library("validation");
	}

	public function index(){			
			
			$this->session->set_userdata(array("Twitter" => ''));
						
			$data['secondTab'] = "General";
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			$accounts = $data['accounts']->result();
			$data['account'] = $accounts[0]->account;
		
		$this->db->order_by("country_name", "asc");
		$data['country_list'] = $this->db->get("country")->result();
		
		
		if($accounts[0]->account)
		
		{		
				$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
				
				$data['countFollower'] = count($arrayF);
						
				$data['id'] = $accounts[0]->id;
				
				$data['accelaration'] = $accounts[0]->accelaration;
		}
		
		$data['menu'] = 'setting';
		
		if(isset($_POST['submit'])){
			
			$rules['email']   	= "trim|xss_clean|required|valid_email|callback_verify_email";
			$rules['country']   = "trim|xss_clean|required|callback_verify_country";
			$rules['sex']   	= "trim|xss_clean|required|callback_verify_sex";

			$this->validation->set_rules($rules);

			
			
			$fields['email']  	= "email";
			$fields['country']  = "country";
			$fields['sex']  	= "sex";

			$this->validation->set_fields($fields);

			if ($this->validation->run() == TRUE){
				
				
				// Update User
				$userData['email'] 		= $_POST['email'];
				$userData['country'] 	= $_POST['country'];
				$userData['sex'] 		= $_POST['sex'];
				$userData['interest'] 	= $_POST['interest'];
			
				
				if($this->session->userdata('acc_setting')=='No'){
					
					$userData['credit_points'] = $this->session->userdata('credit_points') + 25;
					$userData['acc_setting'] = 'Yes';
				}
				
				$user_update   = $this->user_model->updateUser($userData,$this->session->userdata('userid'));
				// View Portion
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				//d($user_details,1);
				$this->session->set_userdata($user_details);
				
				$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
				$accounts = $data['accounts']->result();
				$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
				$data['countFollower'] = count($arrayF);
				$data['account'] = $accounts[0]->account;
				$data['id'] = $accounts[0]->id;
				$data['accelaration'] = $accounts[0]->accelaration;
				$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
				//d($data,1);
				$this->load->view("setting", $data);
			
			}else{
								
				$this->load->view('setting',$data);

			}
		
		}else{
		
			$this->load->view('setting',$data);
		
		}
	}
	
	
	
	public function twitter(){	
	
	        $this->session->set_userdata(array("Twitter" => 'Twitter'));		
			
			$data['secondTab'] = "Twitter";
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			$accounts = $data['accounts']->result();
			$data['account'] = $accounts[0]->account;
			
			
		
			if(!$accounts[0]->account){
			
				redirect('twitterapp');
			}
			
			else{
			
			$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
			
			$data['countFollower'] = count($arrayF);		
			$data['id'] = $accounts[0]->id;
			
			$data['accelaration'] = $accounts[0]->accelaration;
			$data['offered_credit'] = $accounts[0]->offered_credit;
			}
		
		if(isset($_POST['submit']) or isset($_POST['delete'])){
		
				if(isset($_POST['submit']))
				{
					$dataUp['accelaration']   =  $_POST['accelaration'];
					$dataUp['offered_credit']   =  $_POST['credit'];
										
					$account_update   = $this->account_model->updateAccount($dataUp,$this->session->userdata('userid'));
					if($account_update)
					$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
				}
				else if(isset($_POST['delete']))
				{
				    $this->account_model->deleteAccountUserSpecific($this->session->userdata('userid'));
				}
								
				// View Portion
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
				$accounts = $data['accounts']->result();
				
				$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
				$data['countFollower'] = count($arrayF);
				
				$data['account'] = $accounts[0]->account;
				
				
				$data['id'] = $accounts[0]->id;
				
				$data['accelaration'] = $accounts[0]->accelaration;
				$data['offered_credit'] = $accounts[0]->offered_credit;
				
				
				$this->load->view("twitterAccount", $data);
		
		
		}else{
		
			$this->load->view('twitterAccount',$data);
		
		}
	}
	
	
	
		public function retweet(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Retweet";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
			
			
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['retweets'] = $this->tweet_model->getTweets($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
			
			$rules['tweet']   	= "trim|xss_clean|required";
			
			$rules['credit_per_tweet']   	= "trim|xss_clean|required|integer|callback_verify_credit";
			
			$rules['total_offered_credit']   	= "trim|xss_clean|required|integer|callback_verify_credit";
			
			//$rules['total_member_required']   	= "trim|xss_clean|required|integer";

			$this->validation->set_rules($rules);


			$fields['tweet']  	= "Tweet";
			$fields['credit_per_tweet']  	    = "Credit per tweet";
			$fields['total_offered_credit']  	= "Total offered credit";
			//$fields['total_member_required']  	= "Minimun Follower";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
			
				$userData['userid'] = $this->session->userdata('userid');
				$userData['tweet'] = $_POST['tweet'];
				$userData['credit_per_tweet'] = $_POST['credit_per_tweet'];
				$userData['total_offered_credit'] = $_POST['total_offered_credit'];
				if($_POST['total_member_required'])
				$userData['total_member_required'] = $_POST['total_member_required'];
				else $userData['total_member_required'] = 0;
				$userData['timestamp'] = strtotime("now");				
				
				$this->tweet_model->newTweet($userData);
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updata['credit_points'] = $user_details['credit_points'] - $_POST['total_offered_credit'];
				
				$this->user_model->updateUser($updata,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/retweet/1');
				
			}else{
								
				$this->load->view('retweet',$data);

			}
		
		}else{
		
			$this->load->view('retweet',$data);
		
		}
	
	}

	
	
	public function updateRetweet(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Retweet";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
			
			
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['retweets'] = $this->tweet_model->getTweets($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
		
			$rules['creditPT']   	= "trim|xss_clean|required|integer";
			
			$rules['totalOC']   	= "trim|xss_clean|integer|callback_verify_credit";

			$this->validation->set_rules($rules);

			$fields['creditPT']  	= "Credit per tweet";
			$fields['totalOC']  	= "Total offered credit";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
											
				$tweet_id = $_POST['retweet_id'];
				$userData['credit_per_tweet'] = $_POST['creditPT'];
				
				$getSpecificTweet = $this->tweet_model->getSpecificTweet($tweet_id);
				$userData['total_offered_credit'] = $getSpecificTweet[0]->total_offered_credit + $_POST['totalOC'];
				
				$this->tweet_model->updateTweet($userData,$tweet_id);
								
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updatas['credit_points'] = $user_details['credit_points'] - $_POST['totalOC'];
				
				$this->user_model->updateUser($updatas,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/retweet/1');
				
			}else{
								
				$this->load->view('retweet',$data);

			}
		
		}else{
		
			$this->load->view('retweet',$data);
		
		}
	
	}
	
	
	
	
	public function youTube(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			$data['menu'] = 'setting';
			$data['secondTab'] = "YouTube";
			
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
			
			
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['tubes'] = $this->tweet_model->getTubes($this->session->userdata('userid'));
		
		
		if(isset($_POST['submit'])){
			
			$rules['video_url']   	= "trim|xss_clean|required|callback_verify_youtube";
			
			$rules['credit_per_view']   = "trim|xss_clean|required|integer|callback_verify_credit";
			
			$rules['total_credit']   	= "trim|xss_clean|required|integer|callback_verify_credit";
			
			$rules['playing_time']   	= "trim|xss_clean|required|integer";

			$this->validation->set_rules($rules);


			$fields['video_url']  	= "Video url";
			$fields['credit_per_view']  	    = "Credit per view";
			$fields['total_credit']  	= "Total credit";
			$fields['playing_time']  	= "Playing time";

			$this->validation->set_fields($fields);

			if ($this->validation->run() == TRUE){
			
			//
			$check_url = explode("v=",$_POST['video_url']);
			if(!isset($check_url[1])){
			
			$video_id = $_POST['video_url'];
			}else{
			$video = parse_url($_POST['video_url']);
			if(isset($video['query'])){
			$myvideo = explode("v=",$video['query']);
			$video_id = $myvideo[1];
			}
			}
			$temp=explode("&",$video_id);
			
			if($temp[0])
			$video_id=$temp[0];
			
			require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
			Zend_Loader::loadClass('Zend_Gdata_YouTube');
			$yt = new Zend_Gdata_YouTube();
			
			try{
			$videoEntry = $yt->getVideoEntry($video_id);
			}catch(Exception $ex){
					
			}
			if($videoEntry->getVideoId()){
			
			$userData['video_id'] = $videoEntry->getVideoId();
			$userData['video_title'] = $videoEntry->getVideoTitle();
			$userData['video_duration'] = $videoEntry->getVideoDuration();
			$userData['userid'] = $this->session->userdata('userid');
			$userData['credit_per_view'] = $_POST['credit_per_view'];
			$userData['total_credit'] = $_POST['total_credit'];
			$userData['playing_time'] = $_POST['playing_time'];
			$userData['create_date'] = date("Y-m-d H:i:s");
			$video_thumbnail = $videoEntry->getVideoThumbnails();
			$userData['video_thumbnail'] = $video_thumbnail[0]['url'];
			
			$insert = $this->tweet_model->newTube($userData);
			
			$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
			$this->session->set_userdata($user_details);
			
			$updata['credit_points'] = $user_details['credit_points'] - $_POST['total_credit'];
			
			$this->user_model->updateUser($updata,$this->session->userdata('userid'));
			
			$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
			$this->session->set_userdata($user_details);
			
			redirect('setting/youtube/1');
					
			}
			
			//			
				
				
			}else{
								
				$this->load->view('youtube',$data);

			}
		
		}else{
		
			$this->load->view('youtube',$data);
		
		}
	}
	
	
	
	public function updateyouTube(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			$data['menu'] = 'setting';
			$data['secondTab'] = "YouTube";
			
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
			
					
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['tubes'] = $this->tweet_model->getTubes($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
		
			$rules['creditPV']   = "trim|xss_clean|required|integer|callback_verify_credit";
			
			$rules['playingT']   = "trim|xss_clean|required|integer";
			
			$rules['tc']   	= "trim|xss_clean|integer|callback_verify_credit";

			$this->validation->set_rules($rules);

			$fields['creditPV']  = "Credit per view";
			
			$fields['playingT']  = "Playing time";
			
			$fields['tc']  	= "Total credit";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
			
			    $stream_id = $_POST['stream_id'];
				$userData['credit_per_view'] = $_POST['creditPV'];
				$userData['playing_time'] = $_POST['playingT'];
				
				$getSpecificTube = $this->tweet_model->getSpecificTube($stream_id);
				$userData['total_credit'] = $getSpecificTube[0]->total_credit + $_POST['tc'];
								
				$this->tweet_model->updateTubes($userData,$stream_id);
								
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updatas['credit_points'] = $user_details['credit_points'] - $_POST['tc'];
				
				$this->user_model->updateUser($updatas,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/youTube/1');
				
			}else{
								
				$this->load->view('youtube',$data);

			}
		
		}else{
		
			$this->load->view('youtube',$data);
		
		}
	
	}
	
	
	public function websites(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Websites";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['sites'] = $this->tweet_model->getSites($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
			
			$rules['title']   	= "trim|xss_clean|required";
			
			$rules['url']   	= "trim|xss_clean|required|callback_verify_url";
			$rules['detail']   	= "trim|xss_clean|required";
			
			

			$this->validation->set_rules($rules);


			$fields['title']  	= "Title";
			$fields['url']  	= "URL";
			$fields['detail']  	= "Detail";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
				
				$website_url_component  = parse_url(prep_url($_POST['url']));
				$website_url = $website_url_component['scheme']."://".$website_url_component['host'];
				
				$userData['userid'] = $this->session->userdata('userid');
				$userData['title'] = $_POST['title'];
				$userData['url'] = $website_url;
				if($_POST['detail'])
				$userData['detail'] = $_POST['detail'];
				else $userData['detail'] = '';
				$userData['timestamp'] = strtotime("now");				
				//d($userData,1);
				
				$this->tweet_model->insertWebsites($userData);
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updata['credit_points'] = $user_details['credit_points'];
				
				$this->user_model->updateUser($updata,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/websites/1');
				
			}else{
								
				$this->load->view('websites',$data);

			}
		
		}else{
		
			$this->load->view('websites',$data);
		
		}
	
	}
	
	
	
	
	
	
	
	public function updateWebsites(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Websites";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			$arr =  $this->history_model->getHistoryMimicAccountSpecific($accounts[0]->account);
			
			$data['account'] = $accounts[0]->account;
			
			if(count($arr)){
				
				$i = 0;
				foreach($arr as $ret){
				
					$array[$i] = $ret->mimic;
					
				$i++;
				}
			
			$data['mimic'] = $array;	
			
			}
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['sites'] = $this->tweet_model->getSites($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
			
			$rules['titles']   	= "trim|xss_clean|required";
			
			$rules['urls']   	= "trim|xss_clean|required|callback_verify_url";
			
			//$rules['details']   	= "trim|xss_clean|required";
			
			$rules['cpv']   = "trim|xss_clean|required|integer|callback_verify_credit";
			
			$rules['tc']   	= "trim|xss_clean|integer|callback_verify_credit";

			$this->validation->set_rules($rules);


			$fields['titles']  	= "Title";
			$fields['urls']  	= "URL";
			//$fields['details']  = "Detail";
			$fields['cpv']  = "Credit per view";
			$fields['tc']  	= "Total credit";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
			
				$website_url_component  = parse_url(prep_url($_POST['urls']));
				$website_url = $website_url_component['scheme']."://".$website_url_component['host'];
				
				$website_id = $_POST['website_id'];
				$userData['title'] = $_POST['titles'];
				$userData['url'] = $website_url;
				//$userData['detail'] = $_POST['details'];
				$userData['credit_per_view'] = $_POST['cpv'];
					
				$getSpecificSite = $this->tweet_model->getSpecificSite($website_id);
				$userData['total_credit'] = $getSpecificSite[0]->total_credit + $_POST['tc'];
				
				//$this->tweet_model->updateTweet($userData,$tweet_id);
				
				$this->tweet_model->updateSites($userData,$website_id);
								
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updatas['credit_points'] = $user_details['credit_points'] - $_POST['tc'];
				
				$this->user_model->updateUser($updatas,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				
				redirect('setting/websites/1');
				
			}else{
								
				$this->load->view('websites',$data);

			}
		
		}else{
		
			$this->load->view('websites',$data);
		
		}
	
	}
	
	
	
	public function blogs(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Blogs";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			
			$accounts = $data['accounts']->result();
			
			
			$data['account'] = $accounts[0]->account;
						
		if(!$accounts[0]->account){
		
			redirect('twitterapp');
		}else{
		
		$arrayF = $this->history_model->getAccountFollowerSpecificHistory($accounts[0]->account);
		
		$data['countFollower'] = count($arrayF);		
				
		$data['id'] = $accounts[0]->id;
		
		$data['accelaration'] = $accounts[0]->accelaration;
		$data['offered_credit'] = $accounts[0]->offered_credit;
		}
			
		
		$data['blogs'] = $this->tweet_model->getBlogs($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
		
			$rules['blog_url']   	= "trim|xss_clean|required|callback_verify_feed";
			$rules['credit_per_tweet']   = "trim|xss_clean|required|integer|callback_verify_credit";
			$rules['total_credit']   	= "trim|xss_clean|required|integer|callback_verify_credit";
			$rules['minimum_follower']   	= "trim|xss_clean|integer";

			$this->validation->set_rules($rules);
			
			$fields['blog_url'] = "Blog URL";
			$fields['credit_per_tweet'] = "Credit per tweet";
			$fields['total_credit'] = "Total credit";
			$fields['minimum_follower'] = "Minimum follower";

			$this->validation->set_fields($fields);
			
			if ($this->validation->run() == TRUE){
			
			$doc = new DOMDocument();
			$doc->load($_POST['blog_url']);
			$flag=0;
			
			$arrFeeds = array();
			foreach ($doc->getElementsByTagName('item') as $node) {
			
				$itemRSS = array (
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				);
				
			array_push($arrFeeds, $itemRSS);
			}
								
				$userData['userid'] = $this->session->userdata('userid');
				$userData['blog_url'] = $_POST['blog_url'];
				$userData['credit_per_tweet'] = $_POST['credit_per_tweet'];
				if($_POST['minimum_follower'])
				$userData['minimum_follower'] = $_POST['minimum_follower'];
				else $userData['minimum_follower'] = 0;
				$userData['total_credit'] = $_POST['total_credit'];
				$userData['feed_type'] = $_POST['feed_type'];
				$userData['timestamp'] = strtotime("now");	
				
				$arrFeedsrev=array();
				if(arrFeeds)
				$arrFeedsrev=array_reverse($arrFeeds);
				else $arrFeedsrev=$arrFeeds;	
				
				$this->tweet_model->insertBlogs($userData,$arrFeedsrev);
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updata['credit_points'] = $user_details['credit_points'] - $_POST['total_credit'];
				
				$this->user_model->updateUser($updata,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/blogs/1');
				
			}else{
								
				$this->load->view('blogs',$data);

			}
		
		}else{
		
			$this->load->view('blogs',$data);
		
		}
	
	}
	
	
	
	public function updateBlogs(){	
	
	        $this->session->set_userdata(array("Twitter" => ''));		
			
			$data['menu'] = 'setting';
			$data['secondTab'] = "Blogs";	
			
			if($this->uri->segment(3)==1)
			$data['accMSG'] = "<font style='color:#00ff00; font-weight:bold; font-size:13px;'>Your account has been successfully updated.</font>";
								
						
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
			$accounts = $data['accounts']->result();
			$data['account'] = $accounts[0]->account;
			
			
						
		if(!$accounts[0]->account) redirect('twitterapp');
		
		$data['blogs'] = $this->tweet_model->getBlogs($this->session->userdata('userid'));
		
		if(isset($_POST['submit'])){
		
			$rules['cpt']  = "trim|xss_clean|required|integer";
			
			$rules['add_Credit']  = "trim|xss_clean|integer|callback_verify_credit";

			$this->validation->set_rules($rules);

			$fields['cpt']  = "Credit per tweet";
			$fields['add_Credit']  	= "Total offered credit";

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
											
				$blog_id = $_POST['blog_id'];
				$userData['credit_per_tweet'] = $_POST['cpt'];
				$userData['feed_type'] = $_POST['ft'];
				
				$getSpecificBlog = $this->tweet_model->getSpecificBlog($blog_id);
				$userData['total_credit'] = $getSpecificBlog[0]->total_credit + $_POST['add_Credit'];
				
				$this->tweet_model->updateBlog($userData,$blog_id);
								
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				$updatas['credit_points'] = $user_details['credit_points'] - $_POST['add_Credit'];
				
				$this->user_model->updateUser($updatas,$this->session->userdata('userid'));
				
				$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
				$this->session->set_userdata($user_details);
				
				redirect('setting/blogs/1');
				
			}else{
								
				$this->load->view('blogs',$data);

			}
		
		}else{
		
			$this->load->view('blogs',$data);
		
		}
	
	}
	
	
	
	
	public function viewFeeds(){	
		       			
		$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		$accounts = $data['accounts']->result();
		$data['account'] = $accounts[0]->account;
			
		$data['feeds'] = $this->tweet_model->getFeeds($this->uri->segment(3));
				
		if(!$accounts[0]->account) redirect('twitterapp');
			
		$this->load->view('viewFeeds',$data);		
	}
	
	
	public function deleteFeed(){
	
		$this->tweet_model->deleteFeed($this->uri->segment(3));
		echo $this->uri->segment(3);
	}
	
	public function deleteTweet(){
	
		$this->tweet_model->deleteTweet($this->uri->segment(3));
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
		echo $this->uri->segment(3).'---'.$this->session->userdata('credit_points');
	}
	
	public function deleteSites(){
	  
		$this->tweet_model->deleteWebsite($this->uri->segment(3));
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
		echo $this->uri->segment(3).'---'.$this->session->userdata('credit_points');
	}
	
	
	public function deleteTube(){
	
		$this->tweet_model->deleteTube($this->uri->segment(3));
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
		echo $this->uri->segment(3).'---'.$this->session->userdata('credit_points');
	}
	
	public function deleteBlog(){
	
		$this->tweet_model->deleteBlog($this->uri->segment(3));
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
		echo $this->uri->segment(3).'---'.$this->session->userdata('credit_points');
	}
	
	
	function verify_email($str){
	$email =  $this->db->get_where('users', array('email' => $str, 'userid !=' => $this->session->userdata('userid')));
        if($email->num_rows() > 0) {
			$this->validation->set_message('verify_email', 'This email is already existed. Try another.');
			return false;
        } else {
            return true;
        }
    }
	
	function verify_country($str){
	
        if($str == "") {
			$this->validation->set_message('verify_country', 'country field is required');
			return false;
        } else {
            return true;
        }
    }
	
	function verify_sex($str){
	
         if($str == "") {
			$this->validation->set_message('verify_sex', 'sex field is required');
			return false;
        } else {
            return true;
        }
    }
	
	
	function verify_credit($credit){
	
      	$credit_points=$this->user_model->getCredit_points($this->session->userdata('userid'));
				
				if($credit_points>=$credit){
				return true;
				}else{
				$this->validation->set_message('verify_credit', 'You have only <font style="font-weight:bold;text-decoration:underline">'.$credit_points.'</font> credits');
			    return false;
	}
	    }
		
		
		function verify_url($url){
		
		$website_url_component  = parse_url(prep_url($url));
				if(!is_array($website_url_component)){
					$this->validation->set_message('verify_url', 'Please Add Valid Website');
					return false;
					//$data['errMsg'] = "<h3 style='color:red;'>Please Add Valid Website</h3>";
					//$this->load->view('websites',$data); exit;
				}
				
				$website_url = $website_url_component['scheme']."://".$website_url_component['host'];
				
				$var =  preg_match('#^https?://[a-z0-9-]+(\.[a-z0-9-]+)+#', strtolower($website_url));
				if($var ==0 || $var==false){
					$this->validation->set_message('verify_url', 'Invalid Website Url');
					return false;
					//$data['errMsg'] = "<h3 style='color: red;'>Invalid Website Url</h3>";
					//$this->load->view('websites',$data); exit;
				}
				
				return true;
		
		}
		
		function verify_youtube($url){
		
		
			$check_url = explode("v=",$url);
			if(!isset($check_url[1])){
			$video_id = $url;
			}else{
			$video = parse_url($url);
			if(isset($video['query'])){
			$myvideo = explode("v=",$url);
			$video_id = $myvideo[1];
			}
			}
			
			$temp=explode("&",$video_id);
			
			if($temp[0])
			$video_id=$temp[0];
			
			$exist_video = $this->tweet_model->duplicateVideo($video_id,$this->session->userdata('userid'));
			if($exist_video>0){
			$this->validation->set_message('verify_youtube', 'Sorry You have already added this video');
			return false;
			}
			
			require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
			Zend_Loader::loadClass('Zend_Gdata_YouTube');
			$yt = new Zend_Gdata_YouTube();
			try{
			$videoEntry = $yt->getVideoEntry($video_id);
			}catch(Exception $ex){
			$this->validation->set_message('verify_youtube', 'Invalid Video Entry. Plaese Try Again');
			return false;
			}
			
			return true;	
		}
		
		
		
		function verify_feed($url){
		
		error_reporting(E_ERROR);
		$doc = new DOMDocument();
		$doc->load($url);
		$flag=0;
		
		$arrFeeds = array();
		foreach ($doc->getElementsByTagName('item') as $node) {
		
			if(isset($node->getElementsByTagName('title')->item(0)->nodeValue)){
			 if(isset($node->getElementsByTagName('description')->item(0)->nodeValue)){
			   if(isset($node->getElementsByTagName('link')->item(0)->nodeValue)){
				 return true;				 
				}
			  }
			}
		
		}
		
		$this->validation->set_message('verify_feed', 'Invalid RSS feed Url');
		return false;
		}
		
		
		
		function Check_feed(){
		
		error_reporting(E_ERROR);
		$doc = new DOMDocument();
		$doc->load($_REQUEST['url']);
		$flag=0;
		
		$arrFeeds = array();
		foreach ($doc->getElementsByTagName('item') as $node) {
		
			if(isset($node->getElementsByTagName('title')->item(0)->nodeValue)){
			 if(isset($node->getElementsByTagName('description')->item(0)->nodeValue)){
			   if(isset($node->getElementsByTagName('link')->item(0)->nodeValue)){
				 $flag=1;break;
				}
			  }
			}
		
		}
		
		if($flag) echo 1;		
		else echo 0;
		
		}
		
		
}
?>