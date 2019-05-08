<?php 
class Feature extends Controller 

{
	public function __construct(){

		parent::Controller();
		
		$this->load->model("admin/user_model");
		$this->load->model("admin/account_model");
		$this->load->model("admin/history_model");
		$this->load->model("admin/package_model");
	}

	public function index(){
		
		if($this->session->userdata('userid')){
					
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
			$accounts = $data['accounts']->result();
			
			$data['account'] = $accounts[0]->account;
		
		}else{
			
			redirect('main');
		}
		$data['menu'] = 'feature';
		
		$data['account_name'] = $this->account_model->getAccountName()->result();
		
		$data['fea_packages'] = $this->package_model->getFeaturePackage();
		
		$data['point_packages'] = $this->package_model->getPointPackage();
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
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
			
			
		$this->load->view('feature',$data);
	}
	
	public function payment_fail(){
		
		if($this->session->userdata('userid')){
		
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
			$accounts = $data['accounts']->result();
			
			$data['account'] = $accounts[0]->account;
		}
		$data['menu'] = 'feature';
		$data['fea_packages'] = $this->package_model->getFeaturePackage();
		
		$data['point_packages'] = $this->package_model->getPointPackage();
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
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
		
		$data['pay_err_msg'] = "Sorry! Your Payment Is Failed";
		
			
		$this->load->view('feature',$data);
	}
	
	public function payment_success(){
		
		if($this->session->userdata('userid'))
		{
		
			$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		
			$accounts = $data['accounts']->result();
			
			$data['account'] = $accounts[0]->account;
		}
		$data['menu'] = 'feature';
		$data['fea_packages'] = $this->package_model->getFeaturePackage();
		
		$data['point_packages'] = $this->package_model->getPointPackage();
		
		$data['featured_users'] = $this->user_model->getAllFeaturedUsers();
		
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
		
		//$data['pay_msg'] = "Nice! You have successfully brought this package.";
		
		$user_details = $this->user_model->getUserDetails($this->session->userdata('userid'))->row_array();
		$this->session->set_userdata($user_details);
			
		//$this->load->view('feature',$data);
		redirect('main');
	}
	
	function payment_notify(){
		
		if(isset($_REQUEST['payer_id']) && !empty($_REQUEST['payer_id'])){
			
			mysql_connect("localhost","justretw_saikat","techvillagebd") or die(mysql_error());
			mysql_select_db("justretw_retweet") or die(mysql_error());
			
			//mysql_connect("localhost","twiend","twiends#123") or die(mysql_error());
			//mysql_select_db("techvill_twiends") or die(mysql_error());
			
			$arr = $_REQUEST['custom'];
			$array = explode("#",$arr);
			
			$pack = mysql_fetch_object(mysql_query("select * from package where package_id ='".$array[1]."'"));
			
			$userinfo = mysql_fetch_object(mysql_query("select * from users where userid ='".$array[0]."'"));
			
			$time = $pack->package_duration;
			$unit = $pack->package_duration1.'s';
			
			
			$data['credit_points'] = $pack->bonus_points + $userinfo->credit_points;
			//$data['todays_point'] = $pack->bonus_points + $userinfo->todays_point;
			
			$valid_upto = date("Y-m-d",strtotime("+ $time $unit".date("Y-m-d")));

			if($pack->package_type=='Featured VIP'){
				
				$data['isFeatured'] = 'Yes';
				
				$udate = strtotime($userinfo->featured_valid_date);
				$ndate = strtotime("+ $time $unit".date("Y-m-d H:i:s"));
				
				if($udate > $ndate){
					$data['featured_valid_date'] = $userinfo->featured_valid_date;
				}else{			
					$data['featured_valid_date'] = date("Y-m-d H:i:s",strtotime("+ $time $unit".date("Y-m-d H:i:s")));
				}
				
				mysql_query("update users set credit_points = '".$data['credit_points']."', isFeatured = 'Yes', featured_valid_date = '".$data['featured_valid_date']."' where userid = '".$array[0]."'");
				
				mysql_query("insert into payment_history(userid,package_name,package_type,package_value,package_duration,daily_points,payment_date) values('".$array[0]."', '".$pack->package_name."', '".$pack->package_type."', '".$pack->package_value."','".$valid_upto."','".$pack->bonus_points."','".date("Y-m-d")."')");
			
			}else{
				
				mysql_query("update users set credit_points = '".$data['credit_points']."' where userid = '".$array[0]."'");
				
				mysql_query("insert into payment_history(userid,package_name,package_type,package_value,package_duration,daily_points,status,payment_date) values('".$array[0]."', '".$pack->package_name."', '".$pack->package_type."', '".$pack->package_value."','".$valid_upto."','".$pack->bonus_points."','OFF','".date("Y-m-d")."')");
			}
			
		}
		
	}
}
?>