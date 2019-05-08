<?php 
   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class utubeModel extends Model {
		public function __construct(){
			parent::__construct();
		}
	
		public function checkIfAlreadyWatched($stream_id){
			$query   = $this->db->query("select * from youtube_video_activity where video_id = '$video_id' AND userid = '".$this->session->userdata('userid')."'");
			$results = $query->row();
			return !empty($results)? $results : false;
		}
		
		public function getYoutubeSeedByStreamId($id){
			$query   = $this->db->query("select *from youtube_video where stream_id ='".$id."'");
			$results = $query->row();
			return !empty($results)? $results : false;
		}


		public function insertYoutubeSeedActivity($data){
			$this->db->insert("youtube_video_activity",$data);
		}
		public function updateVideoWatcherSeed($userid,$no_of_seed){
			return $this->db->query($sql="update users SET credit_points = credit_points + $no_of_seed where userid=$userid");
		}
		public function updateVideo($stream_id){
			return $this->db->query($sql="update youtube_video SET total_viewer = total_viewer + 1, total_credit = total_credit - credit_per_view where stream_id=$stream_id");
		}
		
		
		public function getCountryTube($country,$userid){
						
			$res = $this->db->query("SELECT stream_id, video_id, video_title, playing_time, video_thumbnail, credit_per_view FROM youtube_video WHERE status='ON' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid' AND country = '$country') AND stream_id NOT IN (SELECT video_id FROM youtube_video_activity WHERE userid = '$userid') AND stream_id NOT IN (SELECT video_id FROM skip_youtube WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc LIMIT 30");
			
			return $res;   

		}
		
		public function getInterestTube($like,$userid){
			
			$res = $this->db->query("SELECT stream_id, video_id, video_title, playing_time, video_thumbnail, credit_per_view FROM youtube_video WHERE status='ON' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid' AND (".$like.")) AND stream_id NOT IN (SELECT video_id FROM youtube_video_activity WHERE userid = '$userid') AND stream_id NOT IN (SELECT video_id FROM skip_youtube WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc LIMIT 30");
			
			return $res;	   

		}
		
		
		public function getAllTube($userid){
		
			$res = $this->db->query("SELECT stream_id, video_id, video_title, playing_time, video_thumbnail, credit_per_view FROM youtube_video WHERE status='ON' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND stream_id NOT IN (SELECT video_id FROM youtube_video_activity WHERE userid = '$userid') AND stream_id NOT IN (SELECT video_id FROM skip_youtube WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc LIMIT 30");
			
			return $res->result();	   

		}
		
		public function insertVideoSkip($data){

			return $this->db->insert("skip_youtube",$data);	

		}

}
	