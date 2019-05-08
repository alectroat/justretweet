<?php session_start();

class TwitterApp extends Controller {

	private $_consumer_key = 'N90NAwq6R7SyAiHiybyDVA';
    private $_consumer_secret = 'mNDRNJ4aV6zX91qiNjzlV2LbCL7U6ivBq9aXPmLI';
	
	function TwitterApp()
	{
		parent::Controller();
		$this->load->library('twitter');
		$this->load->model("admin/user_model");
		$this->load->model("admin/tweet_model");
	}
	
	public function index()
	{
		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;

		// GET THE ACCESS TOKENS		
		$to = $this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $oauth_token = false, $oauth_token_secret = false);
		//Request tokens from twitter 
		$OAUTH_CALLBACK = site_url('twitterapp/callback');
		$tok = $this->twitter->getRequestToken($OAUTH_CALLBACK);
		
		// Set session
		$_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
		$_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
		
		/* Build the authorization URL*/
		$request_link = $this->twitter->getAuthorizeURL($tok['oauth_token']);
	
		header("Location: $request_link");
	}

	public function callback()
	{
		
		$to = $this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
		$info = $this->twitter->getAccessToken($_REQUEST['oauth_verifier']);
		//d($info,1);
		$userInfo = $this->twitter->get("users/show", array("user_id" => $info['user_id']));
		d($userInfo,1);
		if(!$info['user_id'])
		{
			$info['success'] = 0;
		}
		else
		{		
				$query = $this->db->get_where( "accounts", array( 'acc_id' => $info['user_id'] ));
				
				if( $query->num_rows() > 0 ) 
				{
					
					$updata["account"] = $info['screen_name'];
					$updata["acc_pwrd_key_twt"] = $info['oauth_token'];
					$updata["acc_secret_twt"] = $info['oauth_token_secret'];
					$updata["profile_image"] = $userInfo->profile_image_url;
					$updata["follower"] = $userInfo->followers_count;
					$updata["following"] = $userInfo->friends_count;
					$updata["location"] = $userInfo->location;
					$updata["time_zone"] = $userInfo->time_zone;
					$updata["name"] = $userInfo->name;
					$updata["description"] = $userInfo->description;
					$updata["url"] = $userInfo->url;
					$updata["last_update"] = strtotime("now");
					
					$this->db->update("accounts", $updata, array("acc_id" => $info['user_id']));
					$user = $query->row();
					$query   = $this->user_model->getUserDetails($user->userid);
					$user_details = $query->row();
					$this->session->set_userdata($user_details);
					if($this->session->userdata['Twitter']=='Twitter')
					{
					redirect('setting/twitter');
					}
					else
					redirect('profile');
				}
				
				else
				{
					$pass = time();
					$data['username'] = $info['screen_name'];
					$data['password'] = md5($pass);
					$data['plain_password'] = $pass;
					$data['credit_points'] = 100;
					$data['email'] = '';
					
					$query = $this->db->get_where( "users", array( 'username' => $info['screen_name'] ) );
					if( $query->num_rows() > 0 )
					{
						
						if($_COOKIE['r_id']!='')
							{
							$up = $this->user_model->getUserDetails($_COOKIE['r_id'])->result();
							$data3['credit_points'] = $up[0]->credit_points + 25;
							$this->user_model->updateUser($data3,$_COOKIE['r_id']);
							}
						
						$data['username'] = $info['screen_name'].'000NA';
						$this->user_model->newUser($data);
					
					}
					
					else
					{
						
						if($_COOKIE['r_id']!='')
							{
							$up = $this->user_model->getUserDetails($_COOKIE['r_id'])->result();
							$data3['credit_points'] = $up[0]->credit_points + 25;
							$this->user_model->updateUser($data3,$_COOKIE['r_id']);
							}
						
						$this->user_model->newUser($data);
					}
					
					$uid = mysql_insert_id();
					
					
					$true = $this->db->insert("accounts", array( "userid" => mysql_insert_id(), "acc_id" => $info['user_id'], "account" => $info['screen_name'], "acc_pwrd_key_twt" => $info['oauth_token'], "acc_secret_twt" => $info['oauth_token_secret'], "profile_image" => $userInfo->profile_image_url, "follower" => $userInfo->followers_count, "following" => $userInfo->friends_count, "location" => $userInfo->location, "time_zone" => $userInfo->time_zone, "name" => $userInfo->name, "description" => $userInfo->description, "url" => $userInfo->url, "last_update" => strtotime("now"), "timestamp" => strtotime("now"), "offered_credit" => 2));
					
					if($true)
					{
					$msg = $this->db->get_where("signup_message",array())->result();
					$this->twitter->post("statuses/update", array("status" => $msg[0]->signup_message));		
					$info['success'] = 1;
					}
					$query   = $this->user_model->getUserDetails($uid);
					$user_details = $query->row();
					$this->session->set_userdata($user_details);
				
					if($this->session->userdata['Twitter']=='Twitter')
					redirect('setting/twitter');
					else
					redirect('profile');
				
			}
		}
	}
}
?>