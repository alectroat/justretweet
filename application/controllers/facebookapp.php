<?php
class FacebookApp extends Controller {

	private $_app_id = '424052694303582';
    private $_app_secret = '6afb30c795aa8de537b7274ee8609b0a';
	
	function FacebookApp()
	{
		parent::Controller();
	}
	
	public function index()
		{
			$array = array();
			$profile = array();
			$uid = $this->session->userdata("setid");
			if(!$uid){
				$this->session->set_userdata(array("adderror" => "<span style=\"color:#FF0000\">Some problem there, please try again.</span>"));
				redirect('main');
			}
			
			try{
				$this->load->library('facebook');
			}
			catch(Exception $o){
				error_log($o);
			}
			
			$config['appId']  = $this->_app_id; 
			$config['secret'] = $this->_app_secret;
			$config['cookie']  = true;
			
			$this->facebook->FacebookAuth($config);
			$this->facebook->setAccessToken($this->session->userdata("access_token"));
			$fbme = $this->facebook->api('/me');
			
			$this->facebook->setAccessToken($this->session->userdata('access_token'));
			$access_token = $this->facebook->getAccessToken();

			$url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->_app_id.'&client_secret='.$this->_app_secret.'&grant_type=fb_exchange_token&fb_exchange_token='.$access_token;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);

			curl_close($ch);

			// parse response
			parse_str($response, $token_data);

			$token_time = time() + $token_data['expires'];
			// exchanged token
			$access_token = $token_data['access_token'];

			if($fbme['id'])
			{
			//$qry = $this->db->get_where("userinfo",array("user_id" => $userInfo->id))->result();
			
			if(!$this->session->userdata('user_id'))
			{
				$qry = $this->db->get_where("userinfo",array("profile_id" => $fbme['id'], "profile_type" => 'facebook'))->result();
				if($qry)
				{
					
					$this->session->set_userdata(array("user_id" =>$qry[0]->user_id));
					$this->db->update("userinfo",array("parent_id" => $qry[0]->user_id),array("user_id" => $qry[0]->user_id));
					redirect('profile');
				}
				else
				{
					$max_id = $this->db->query("select max(user_id) as max_id from userinfo")->result();
					
					$array['user_id'] 				= $array['parent_id'] 	= $max_id[0]->max_id+1;
					$array['profile_id'] 			= $fbme['id'];
					$array['profile_type'] 		 	= 'facebook';
					$array['screen_name']   		= $fbme['username'];
					$array['display_name']   		= $fbme['name'];
					$array['access_token']			= $access_token;
					$array['token_time']			= $token_time;
					
					$array['entry_date']   			= time();
					$array['last_update']   		= time();
					//d($array,1);
					$this->db->insert("userinfo",$array);
					$this->session->set_userdata(array("user_id" => mysql_insert_id()));
					redirect("profile");
										
				}
				
				
			}
			
			elseif($this->session->userdata('user_id'))
			{
				$qry = $this->db->get_where("userinfo",array("profile_id" => $fbme['id'], "profile_type" => 'facebook'))->result();
				//d($qry,1);
				if($qry)
				{
					if($qry[0]->parent_id ==$this->session->userdata('user_id'))
					    {
						$this->db->update("userinfo",array("last_update" => time()),array("user_id" => $qry[0]->user_id));
						redirect("profile");
					    }
					else
					    {
						
						$this->session->set_userdata(array("error"=>"This account has been already added ...please try another one."));
						//d($this->session,1);
						redirect("profile");
					    }
					
				}
				else
					   {
					
						$array['parent_id'] 			= $this->session->userdata('user_id');
						$array['profile_id'] 			= $fbme['id'];
						$array['profile_type'] 		 	= 'facebook';
						$array['screen_name']   		= $fbme['username'];
						$array['display_name']   		= $fbme['name'];
						$array['access_token']			= $access_token;						
						$array['entry_date']   			= time();
						$array['last_update']   		= time();
						//d($array,1);
						$this->db->insert("userinfo",$array);
						
						//redirect("profile");
				        }	
				
				
		       }
		
		header("Location: https://www.facebook.com/logout.php?next=".site_url()."profile&access_token=".$access_token);
	}
			else
				{
				$this->session->set_userdata(array("adderror" => "<span style=\"color:#FF0000\">Some problem there, please try again.</span>"));
				redirect('main');
				}
		}

	function facebook_func()
	{
				$face_id = $this->uri->segment(3);
				$qry = $this->db->get_where("user",array("facebook_id" => $face_id))->result();
				//d($qry,1);
				$this->session->set_userdata(array("user_id" => $qry[0]->user_id));
				redirect('profile');
		
	}
	public function setSession()
	{
				$uid = $_REQUEST['setid'];
				$token = $_REQUEST['token'];
				$this->session->set_userdata(array("setid" => $uid, "access_token" => $token));
				echo $uid; exit;
	}

}
?>