<?php 

class Twitter extends Controller 

{
	public function __construct(){
		
		
		
		parent::Controller();
		
		$this->load->model("admin/account_model");
		$this->load->model("admin/user_model");
		$this->load->model("admin/tweet_model");
		$this->load->model("admin/history_model");
		
	}

	public function index(){
		
		if(!$this->session->userdata('userid')){
			
			redirect('main');
		}
			
			$demoFollowList = $this->user_model->getAllAccount($this->session->userdata('userid'))->result();
			
			
			
			$i=-1;
			foreach($demoFollowList as $list){
			$i++;
			$temp_array[$i]->id 			= $list->id;
			$temp_array[$i]->account_name	= $list->account;
			$temp_array[$i]->account		= $list->acc_id;
			$temp_array[$i]->profile_image  = $list->profile_image;
			
			if($list->credits >= $list->offered_credit)
			$temp_array[$i]->offered_credit	= $list->offered_credit;
			else $temp_array[$i]->offered_credit=0;				
			}
			
			
			if($temp_array){
			foreach($temp_array as $value) {
             $sort_numcie[] 				= $value->offered_credit;
            }			
			array_multisort($sort_numcie, SORT_DESC, $temp_array);
			}

            
            $data['follow_list'] = $temp_array;
				
			//echo "<pre>";print_r($data['follow_list']);exit;
						
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
			
			}else{
				$data['mimic'] = array();
			}
			
		
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
		$data['adds'] = $this->tweet_model->getAdds();
		
		$data['menu'] = 'twitter';
		
		$data['submenu'] = 'all';
		
		$this->load->view('twitter',$data);
	}
	
	
	public function country(){
		
		if(!$this->session->userdata('userid')){
			
			redirect('main');
		}	
						
			
			$demoFollowList = $this->user_model->getCountryAccount($this->session->userdata('country'),$this->session->userdata('userid'))->result();
			
			$i=-1;
			foreach($demoFollowList as $list){
			$i++;
			$temp_array[$i]->id=$list->id;
			$temp_array[$i]->account=$list->account;
			$temp_array[$i]->profile_image=$list->profile_image;
			
			if($list->credits >= $list->offered_credit)
			$temp_array[$i]->offered_credit=$list->offered_credit;
			else $temp_array[$i]->offered_credit=0;			
			
			}
			
			if($temp_array){
			foreach($temp_array as $value) {
             $sort_numcie[] = $value->offered_credit;
            }
            array_multisort($sort_numcie, SORT_DESC, $temp_array);
			}
			
            $data['follow_list'] = $temp_array;
			
											
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
			
			}else{
				$data['mimic'] = array();
			}
			
		
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
		$data['adds'] = $this->tweet_model->getAdds();
		
		$data['menu'] = 'twitter';
		
		$data['submenu'] = 'country';
		
		$this->load->view('twitter',$data);
	}
	
	
	public function interest(){
		
		if(!$this->session->userdata('userid')){
			
			redirect('main');
		}
			
			if($this->session->userdata('interest')){
			
				$inters = explode(",",$this->session->userdata('interest'));
				
				$like = '';
				if(is_array($inters)){
						$i = 0;
						foreach($inters as $inter){
						
						$like .= "interest like '%".$inter."%' or ";
						
						$i++;
					}
					
					$demoFollowList = $this->user_model->getInterestAccount(rtrim($like," or "),$this->session->userdata('userid'))->result();
			
					$i=-1;
					foreach($demoFollowList as $list){
					$i++;
					$temp_array[$i]->id=$list->id;
					$temp_array[$i]->account=$list->account;
					$temp_array[$i]->profile_image=$list->profile_image;
					
					if($list->credits >= $list->offered_credit)
					$temp_array[$i]->offered_credit=$list->offered_credit;
					else $temp_array[$i]->offered_credit=0;			
					
					}
					
					if($temp_array){
					foreach($temp_array as $value) {
					 $sort_numcie[] = $value->offered_credit;
					}		
					array_multisort($sort_numcie, SORT_DESC, $temp_array);
					}
					
					$data['follow_list'] = $temp_array;
				}
			}
			
			
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
			
			}else{
				$data['mimic'] = array();
			}
			
		
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
		$data['adds'] = $this->tweet_model->getAdds();
		
		$data['menu'] = 'twitter';
		
		$data['submenu'] = 'interest';
		
		$this->load->view('twitter',$data);
	}
	
	public function skip(){
	
	if(!$this->session->userdata('userid')){
			
			redirect('main');
		}
		
	//echo $this->uri->segment(3);exit;
	$data['userid'] = $this->session->userdata('userid');
	$data['account_id'] = $this->user_model->getIdfromName($this->uri->segment(3));
	$this->user_model->insertSkip($data);
	echo $this->uri->segment(3);
	
	}
	
	public function profile()
		{
			$twitter_id = $this->uri->segment(3);
			if(is_numeric($twitter_id)){
				$data['profile'] = $this->account_model->getTwitterUserDetailsByTwitterid($twitter_id);
				
				if($data['profile']){
					echo $this->load->view('sticky_tooltip',$data,true);
				}else{
					echo "<h3 style='color:red;'>Sorry!!!! We could not find any information.</h3>";
				}
				
			}else{
				echo "<h3 style='color:red;'>Sorry!!!! Invalid Trying</h3>";
			}
		}
	
}
?>