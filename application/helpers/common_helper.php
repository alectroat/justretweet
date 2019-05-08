<?php 

   if ( ! defined('BASEPATH')) exit('No direct script access allowed');



    function d($var, $e=false){

	  echo "<pre>";

	  print_r($var);

	  echo "</pre>";
	  
	  if($e) exit;

    }

	function isLogin($id,$redirect=false){

		$ci         = & get_instance();

		$id         = $ci->session->userdata($id);

		if($id){

			return true;

		}else{

			if($redirect){

				redirect($redirect);

			}else{

				return false;

			}

		}

	}

	function get(){

		parse_str($_SERVER['REQUEST_URI'],$get);

		$i=0;

		foreach($get as $key => $val){

			if($i==0)

				$key = substr(strstr($key,'?'),1);

			$result[$key] = $val;

		  	$i++;

		}

		return $result;

	}
	
function getShortUrl($longUrl){
	
	$bitly            = new Bitly();
	$loginUsername    = "atarue8";
    $apiKey           = "R_38c0f6863583c5e03aa7c48e53db01ec";
    $bitly->setAuthentication($loginUsername, $apiKey);
    $shortUrl         = $bitly->getShortURL($longUrl);
    
		return $shortUrl;
	}

function getShortUrlFromText($text){
		$text_array = explode(' ',$text);
		$i=0;
		foreach($text_array as $txr){
			if(substr($txr,0,7)=='http://' || substr($txr,0,8)=='https://' || substr($txr,0,4)=='www.'){
				if(substr($txr,0,13)!='http://bit.ly')
        	$shortUrl = $this->getShortUrl($txr);
        if(substr($shortUrl,0,13)=='http://bit.ly')
					$text_array[$i] = $shortUrl;
			}
			$i++;				
		}
		return implode(' ',$text_array);
  }
  
function utime($value,$userTZ,$apply=false)
{
	/*
	if(!$userTZ){
		$userTZ = app()->user->isGuest?app()->param('timeZone'):app()->user->modelData('timeZone');
	}
	*/
	return applyGMT($value,$userTZ,$apply);
}

function applyGMT($value,$offset,$apply=true,$dst=true)
	{
		$difference = $offset*3600;
		if($dst)
			$difference+= date('I',$value)*3600;
		return $apply ? $value - $difference : $value + $difference;
	}
	
function tweetTime($time){
		  $diff = time() - $time;
		  
		  if (date("Y") > date("Y",$time)) return date("M j, Y, H:i",$time);
		  else return date("M j, H:i",$time);
		 
	}
	
function addAcronym($text){
		$text_array = explode(' ',$text);
		$i=0;
		//d($text_array,1);
		foreach($text_array as $txr){
		
			if(substr($txr,0,7)=='http://' || substr($txr,0,8)=='https://' || substr($txr,0,4)=='www.'){
			
				$text_array[$i] = "<a style='color:#0084B4' href='".$txr."' target='_blank'>".$txr."</a>";
								
			}else{
				$text_array[$i] = $txr;
			}
			$i++;
		}
		//exit;
		return implode(' ',$text_array);
  }
  
function array2json($arr) {
		
		if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
		$parts = array();
		$is_list = false;
	
		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr)-1;
		if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
				if($i != $keys[$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
	
		foreach($arr as $key=>$value) {
			if(is_array($value)) { //Custom handling for arrays
				if($is_list) $parts[] = array2json($value); /* :RECURSION: */
				else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if(!$is_list) $str = '"' . $key . '":';
	
				//Custom handling for multiple data types
				if(is_numeric($value)) $str .= $value; //Numbers
				elseif($value === false) $str .= 'false'; //The booleans
				elseif($value === true) $str .= 'true';
				else $str .= '"' . addslashes($value) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
	
				$parts[] = $str;
			}
		}
		$json = implode(',',$parts);
		
		if($is_list) return '[' . $json . ']';//Return numerical JSON
		return '{' . $json . '}';//Return associative JSON
} 

if(!function_exists('twitter_time')){
	   function twitter_time($time) {
		  $delta = strtotime("now") - strtotime($time);
		  if ($delta < 60) {
			return 'less than a minute ago';
		  } else if ($delta < 120) {
			return 'about a minute ago';
		  } else if ($delta < (45 * 60)) {
			return floor($delta / 60) . ' minutes ago';
		  } else if ($delta < (90 * 60)) {
			return 'about an hour ago.';
		  } else if ($delta < (24 * 60 * 60)) {
			return floor($delta / 3600) . ' hours ago';
		  } else if ($delta < (48 * 60 * 60)) {
			return '1 day ago';
		  } else {
			return floor($delta / 86400) . ' days ago';
		  }
	   }
	 }
	 
	function random($length, $allow = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") {

    $i = 1;
	$ret="";
    while ($i <= $length) {
   
        $max  = strlen($allow)-1;
        $num  = rand(0, $max);
        $temp = substr($allow, $num, 1);
        $ret  = $ret . $temp;
        $i++;
    }
    return $ret;   
}