<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Package_model extends Model {

		public function __construct(){

			parent::Model();

		}
		
		public function getPackage($limit,$offset){

			$offset = $offset -1;
			$this->db->order_by("package_id", "desc");
			$res = $this->db->get_where('package',array(),$limit,$offset);
			
			return $res;	   

		}
		
		public function getAccount(){


			$this->db->order_by("pay_acc_id", "desc");
			$res = $this->db->get_where('payaccount',array());
			
			return $res;	   

		}
		public function getSignUpMsg(){

			$res = $this->db->get_where('signup_message',array());
			
			return $res;	   

		}
		public function getPaymentHistory($limit,$offset){

			$offset = $offset -1;
			
			$res = $this->db->query("SELECT payment_id, userid,(SELECT username FROM users WHERE userid=payment_history.userid) AS username, package_name, package_type, package_value, package_duration, daily_points, payment_date FROM payment_history ORDER BY payment_id DESC LIMIT ".$offset.",".$limit."");
			
			return $res;	   

		}
		
		public function getFeaturePackage(){
			
			//$this->db->limit(3);
			$this->db->order_by('package_value','DESC');
			$res = $this->db->get_where('package', array('package_type' => 'Featured VIP'));
			
			return $res;	   

		}
		
		public function getPointPackage(){
			
			//$this->db->limit(3);
			$this->db->order_by('package_value','DESC');
			$res = $this->db->get_where('package', array('package_type' => 'One off Purchases'));
			
			return $res;	   

		}
		
		public function deletePackage($id){
			return $this->db->delete('package', array('package_id' => $id));
		}
		
		public function deleteAccount($id){
			return $this->db->delete('payaccount', array('pay_acc_id' => $id));
		}
		public function mdeletePackage($id){
			
			return $this->db->delete('package',array('package_id' => $id));
		}
		
		public function deletePaymentHistory($id){
			return $this->db->delete('payment_history', array('payment_id' => $id));
		}
		
		
		public function save_package($data2){
			$data = array(
						  	'package_name'      => $data2['package_name'],
							'package_type'      => $data2['package_type'],
							'package_duration'  => $data2['duration'],
							'package_duration1' => $data2['duration1'],
							'package_value'     => $data2['package_value'],
							'bonus_points'      => $data2['bonus_points']
						 );
						 
			$res = $this->db->insert('package',$data);
			if($res)
			{
				return 1;
			}
		}
		
		
			public function save_account($data2)
			{
			$data = array('account_name'      => $data2['account_name']);
						 
			$res = $this->db->insert('payaccount',$data);
			if($res)
			{
				return 1;
			}
		}
		
		public function savemsg_account($data2)
			{
			$data = array('signup_message'      => $data2['message_name']);
						 
			$res = $this->db->insert('signup_message',$data);
			if($res)
			{
				return 1;
			}
		}
		
		
		public function editPackage($id){
			return $this->db->get_where('package',array('package_id' => $id));
		}
		public function editAccount($id){
			return $this->db->get_where('payaccount',array('pay_acc_id' => $id));
		}
		
		public function packageDetail($id){
			$res = $this->db->get_where('package',array('package_id' => $id));
			return $res->result();
		}
		
		public function updatePackage($data2){
		
			$data = array(
						  'package_name'     => $data2['package_name'],
						  'package_type'     => $data2['package_type'],
						  'package_duration' => $data2['duration'],
						  'package_duration1'=> $data2['duration1'],
						  'package_value'    => $data2['package_value'],
						  'bonus_points'     => $data2['bonus_points']
						 );
						 
			$this->db->where('package_id', $data2['package_id']);
			$this->db->update("package", $data);
			return 1;
		}
		
		public function updateSetting($data2){
		
			$data = array('account_name'     => $data2['account_name']);
						 
			$this->db->where('pay_acc_id', $data2['pay_acc_id']);
			$this->db->update("payaccount", $data);
			return 1;
		}
		
		public function save_banner($banner_img,$banner_url){
			$data = array(
						  	'banner_img'      => $banner_img,
							'banner_link'      => $banner_url
						 );
						 
			$res = $this->db->insert('banner',$data);
			if($res)
			{
				return mysql_insert_id();
			}
			
			return 0;
		}
		
		
}