<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends Model {	

		public function __construct(){

			parent::Model();

		}
		
		public function getAllUsers($limit,$offset)
			{
			$offset = $offset -1;
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('accounts','users.userid = accounts.userid');
			$this->db->order_by("users.userid", "desc",$limit,$offset);
			$res = $this->db->get();
			return $res;	   
			}
				
		public function getSpecificUser($username){
			
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('accounts', 'users.userid = accounts.userid');
			$this->db->where('accounts.account',$username);
			$query = $this->db->get();
			return $query;

		}
		
		public function getAllFeaturedUsers(){
			
			$res = $this->db->query("SELECT A.*, U.userid, U.isFeatured FROM accounts as A left join users as U on(A.userid=U.userid) WHERE U.isFeatured='Yes' AND  U.featured_valid_date > CURDATE() AND U.status='Active' AND A.status='Active' AND A.accelaration = 'ON' ORDER BY RAND() DESC LIMIT 28");
			
			return $res;	   

		}
		
		public function getAllYouTubeVideos(){
						
			$res = $this->db->query("SELECT * FROM youtube_video ORDER BY RAND() DESC LIMIT 15");
			
			return $res;	   

		}
		
		public function getCountryAccount($country,$userid){
						
			$res = $this->db->query("SELECT id, userid, (SELECT credit_points FROM users WHERE userid = accounts.userid) as credits, acc_id, offered_credit, account, profile_image FROM accounts WHERE accelaration = 'ON' AND status='Active' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid' AND country = '$country') AND account NOT IN (SELECT mimic FROM credit_history WHERE userid = '$userid') AND userid NOT IN (SELECT account_id FROM skip_accounts WHERE userid = '$userid') ORDER BY offered_credit desc LIMIT 28");
			
			return $res;	   

		}
		
		public function getInterestAccount($like,$userid){
		
			$res = $this->db->query("SELECT id, userid, (SELECT credit_points FROM users WHERE userid = accounts.userid) as credits, acc_id, offered_credit, account, profile_image FROM accounts WHERE accelaration = 'ON' AND status='Active' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid' AND (".$like.")) AND account NOT IN (SELECT mimic FROM credit_history WHERE userid = '$userid') AND userid NOT IN (SELECT account_id FROM skip_accounts WHERE userid = '$userid') ORDER BY offered_credit desc LIMIT 28");
			
			return $res;	   

		}
		
		
		public function getAllAccount($userid){
		
			$res = $this->db->query("SELECT id, userid, (SELECT credit_points FROM users WHERE userid = accounts.userid) as credits, acc_id, offered_credit, account, profile_image FROM accounts WHERE accelaration = 'ON' AND status='Active' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND account NOT IN (SELECT mimic FROM credit_history WHERE userid = '$userid') AND userid NOT IN (SELECT account_id FROM skip_accounts WHERE userid = '$userid') ORDER BY offered_credit desc LIMIT 28");
			
			return $res;	   

		}
		
		public function newUser($data){

			return $this->db->insert("users",$data);	

		}
		
		public function updateUser($data,$userid){
			
			return $this->db->update("users",$data,array("userid" => $userid));	  

		}
				
		public function deleteUser($userid){

			$this->db->delete("users",array("userid" => $userid));
			$this->db->delete("accounts",array("userid" => $userid));
			$this->db->delete("blog",array("userid" => $userid));
			$this->db->delete("blog_feed",array("userid" => $userid));	
			$this->db->delete("credit_history",array("userid" => $userid));
			$this->db->delete("feed_history",array("userid" => $userid));
			$this->db->delete("payment_history",array("userid" => $userid));	
			$this->db->delete("retweets",array("userid" => $userid));
			$this->db->delete("retweet_history",array("userid" => $userid));
			$this->db->delete("skip_accounts",array("userid" => $userid));
			$this->db->delete("skip_blog_feed",array("userid" => $userid));
			$this->db->delete("skip_facebookpage",array("userid" => $userid));
			$this->db->delete("skip_retweet",array("userid" => $userid));
			$this->db->delete("skip_wesite",array("userid" => $userid));
			$this->db->delete("skip_youtube",array("userid" => $userid));
			$this->db->delete("user_interests",array("userid" => $userid));		
			$this->db->delete("websites",array("userid" => $userid));
			$this->db->delete("websites_activity",array("userid" => $userid));
			$this->db->delete("youtube_video",array("userid" => $userid));	
			$this->db->delete("youtube_video_activity",array("userid" => $userid));
					   
	   

		}

		public function getUserDetails($userid){

		    return $query = $this->db->get_where('users',array('userid' => $userid));

		    //return $query->row();

	    }
		
		public function user_details($data){

		    $query = $this->db->get_where('users',array('username' => trim($data['username']),'password' => md5($data['password'])));
			
			if($query->num_rows == 0)
			{
		    return 0;
			}
			else{
				return $query->row_array();
			}

	    }
		
		public function getUserAccount($userid){
			return $qry = $this->db->get_where('accounts',array('userid' => $userid));
		}

		public function total_users(){

			$query = $this->db->get('users');

		    return $query->num_rows();   

		}	
		
		public function get_ip()
		{
			$this->db->select_max('logid');
			$qry = $this->db->get('admin_logs');
			
			foreach($qry->result() as $ret)
			{
				$logid = $ret->logid;
	
			}
			$log_id = $logid - 1;
			
			$this->db->select('*');
			$res = $this->db->get_where('admin_logs', array('logid' => $log_id));
			
			return $res;
		}
		
		public function get_adminUser($adminid){
		
			$this->db->select('adminname');
			$qry = $this->db->get_where('admin', array('admin_id' => $adminid));
			foreach($qry->result() as $ret)
			{
				$adminname = $ret->adminname;
			}
			return $adminname;
		}
		
		public function check_status(){

		    $query = $this->db->get_where('users',array('username' => trim($_POST['username']),'password' => md5($_POST['password'])));

		    return $query->num_rows();

	    }
		
		public function getCredit_points($userid){
		
			$this->db->select('credit_points');
			$qry = $this->db->get_where('users', array('userid' => $userid));
			$result=$qry->result();
			return $result[0]->credit_points;
			
		}
		
		public function insertSkip($data){

			return $this->db->insert("skip_accounts",$data);	

		}
		
		public function getIdfromName($account){
			//d($account,1);
			$qry = $this->db->get_where('accounts', array('acc_id' => $account));
			$result=$qry->result();
			return $result[0]->userid;

		}
		
		public function checkDupFollower($mimic,$acc_name){

			$qry = $this->db->get_where('credit_history', array('mimic' => $mimic,'acc_name' => $acc_name));
			return $qry->num_rows();

		}
		
		public function getAllUserEmail(){

			$this->db->select('username,email');
			$this->db->from('users');
			$this->db->where('status','Active');
			$this->db->where('email != ""');
			$query = $this->db->get();
			
			return $query->result();

		}
		
}