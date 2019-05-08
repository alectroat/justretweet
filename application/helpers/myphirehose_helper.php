<?php 
     if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	 if(!function_exists('saveJsonTweet')){
		 function saveJsonTweet($status){
			
			//d(json_decode($status),1);
			
			$CI =& get_instance();
			if(!$CI->db){
				$CI->load->library("database");
			}
			
			$tweet_object      = json_decode($status);
			$data['tweet_id']  = $tweet_object->id_str;
			// If there's a ", ', :, or ; in object elements, serialize() gets corrupted 
			// You should also use base64_encode() before saving this
			$data['cache'] = base64_encode(serialize($tweet_object));
			$CI->db->insert('cache',$data);
			
		 }
	 }