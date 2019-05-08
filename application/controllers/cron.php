<?php
class Cron extends Controller {

	private $_consumer_key = 'blYq3DKAnabgJujmadbOIA';
    private $_consumer_secret = 'FzYJJBldxSf3s2NBaMATitWKeovn8dLtIfQGJTc';
	private $_app_id = '424052694303582';
    private $_app_secret = '6afb30c795aa8de537b7274ee8609b0a';
	
	private $_data = array();

	function Cron()
	{
		parent::Controller();
		$this->load->library('twitter');
		$this->load->library('facebook');
	}
	
	public function index()
	{
			
		$config['appId']  = $this->_app_id; 
		$config['secret'] = $this->_app_secret;
		$config['cookie']  = true;
			
		$this->facebook->FacebookAuth($config);
		$qry =$this->db->query("Select * from message where post_status= 'pending' and msg_text !='NULL' and posttime >='".(time()-900)."' and posttime <= '".time()."' ");
		
		if($qry->num_rows>0 )
		{	
			foreach($qry->result() as $row)
			{
				$access = $this->db->get_where("userinfo",array("profile_id" => $row->profile_id))->result();
				if($access[0]->profile_type == "twitter")
				{
					$this->twitter->TwitterOAuth($this->_consumer_key, $this->_consumer_secret, $access[0]->access_token, $access[0]->access_token_secret);
					$send = $this->twitter->post("statuses/update", array("status" => $row->msg_text));
					if(!$send->error)
						{
						$this->db->update("message",array("post_status" => 'delivered' ),array("msg_id" => $row->msg_id));
						}
				}
						
				if($access[0]->profile_type == 'facebook')
				{
					try {
						$post = $this->facebook->api('/'.$access[0]->profile_id.'/feed', 'POST', array("message" => $row->msg_text));
						$this->db->update("message",array("post_status" => 'delivered' ),array("msg_id" => $row->msg_id));
						}
					catch(Exception $o)
						{
						error_log($o);
						}
								
				}
			
			}//end of foreach
			
		}//end of if qry
	}//end of index
	
}
?>