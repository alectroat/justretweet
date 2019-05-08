<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class History_model extends Model {



		



		public function __construct(){



			parent::Model();



		}

		

		public function getAllHistory($limit,$offset){



			$offset = $offset -1;

			$this->db->order_by("history_id", "desc");

			$res = $this->db->get_where('credit_history',array(),$limit,$offset);

			

			return $res;	   



		}

		

		public function newHistory($data){



			return $this->db->insert("credit_history",$data);	



		}

		

		

		public function newScheduleTweet($data){



			return $this->db->insert("schedule_tweet",$data);	



		}

		

		public function getAllScheduleTweets(){		 

 		

		    $this->db->select('*');

			$this->db->from('schedule_tweet');

			$query = $this->db->get();

			

			return $query->result();

		}

		

		public function deleteScheduleTweet($id){

			

			return $this->db->delete("schedule_tweet",array("id" => $id));

		}

		

		

		public function updateHistory($data){



			return $this->db->update("credit_history",$data,array("history_id" => $_POST['history_id']));	  



		}



		public function deleteHistory($history_id){



			return $this->db->delete("credit_history",array("history_id" => $history_id));			   



		}



		public function getHistoryDetails($history_id){



		    return $query = $this->db->get_where('credit_history',array('history_id' => $history_id));



		    //return $query->row();



	    }



		public function total_history(){



			$query = $this->db->get('credit_history');



		    return $query->num_rows();   



		}

		

		public function getHistoryAccountSpecific($acc_name){

		

			return $this->db->get_where("credit_history",array("acc_name" => $acc_name))->result();

			

		}

		

		public function getAccountFollowerSpecificHistory($acc_name){

		

			return $this->db->get_where("credit_history",array("mimic" => $acc_name))->result();

			

		}

		

		public function getHistoryMimicAccountSpecific($acc_name){

			

			$this->db->select('mimic');

			return $this->db->get_where("credit_history",array("acc_name" => $acc_name))->result();

			

		}

		

		public function deleteHistoryUserSpecific($userid){

			

			return $this->db->delete("credit_history",array("userid" => $userid));

		}	

		

		public function deleteHistoryAccountSpecific($acc_name){

		

			return $this->db->delete("credit_history",array("acc_name" => $acc_name));

		}

		

		public function newSummary($data){



			return $this->db->insert("summary",$data);	



		}

		

		public function getAllSummary($user,$limit,$offset){		 

 		

		    $this->db->select('*');

			$this->db->from('summary');

			$this->db->where('user1',$user);

			$this->db->or_where('user2',$user);

			$this->db->order_by('summary_id','desc');

			$this->db->limit($limit,$offset);

			$query = $this->db->get();

			

			return $query->result();

		}

		

		public function getSpecificSummary($user,$condition1,$condition2,$limit,$offset){		 

 	       

		    $where = "(activity= '".$condition1."' or activity= '".$condition2."') and (user1= '".$user."' or user2= '".$user."')";	

		

		    $this->db->select('*');

			$this->db->from('summary');

			$this->db->where($where);

			//$this->db->where('user1',$user);

			//$this->db->or_where('user2',$user);

			$this->db->order_by('summary_id','desc');

			$this->db->limit($limit,$offset);

			$query = $this->db->get();

			

			return $query->result();

		}

		

		public function getAllSummarycount($user){		 

 			//d($user,1);

		    $this->db->select('*');

			$this->db->from('summary');

			$this->db->where('user1',$user);

			$this->db->or_where('user2',$user);

			$query = $this->db->get();

			

			return $query;

		}

		

		public function getSpecificSummaryCount($user,$condition1,$condition2){		 

 		

		    $where = "(activity= '".$condition1."' or activity= '".$condition2."') and (user1= '".$user."' or user2= '".$user."')";

			$this->db->select('*');

			$this->db->from('summary');

			$this->db->where($where);

			$query = $this->db->get();

			

			return $query;

		}



}