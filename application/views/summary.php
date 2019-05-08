<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?php echo base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?=site_url();?>asset/js/stickytooltip.js"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url();?>asset/css/stickytooltip.css" />
<script type="text/javascript">
     var userdetails = {};
	 function showTooltip(twitter_id){
		 if(userdetails[twitter_id]){
			 $("#sticky1").html(userdetails[twitter_id]);
		 }else{
			 $("#sticky1").html('<img src="<?=site_url()?>asset/images/ajax-loader_round.gif"/>');
			 $.ajax({
			  type: "POST",
			  url: "<?php echo site_url()?>twitter/profile/"+twitter_id,
			  cache: true,
			  success: function(html){
			  
			  //alert(html);
				  userdetails[twitter_id] = html;
				  $("#sticky1").html(html);
			  }
			});
		 }
	 }
</script>

<script type="text/javascript">
function chk()
	{
		document.getElementById('msgBox').style.display = "";
		document.getElementById('msgBoxContent').innerHTML = 'Please Sign In Before You Follow Someone.&nbsp;<a href="<?php echo site_url('twitterapp')?>">Login Here</a>';
	}
function ch()
	{
		document.getElementById('msgBox').style.display = "";
		document.getElementById('msgBoxContent').innerHTML = 'Please Sign In Before You Buy Something.&nbsp;<a href="<?php echo site_url('twitterapp')?>">Login Here</a>';
	}
function follow(id,name,pos)
	{ 	//alert(pos);
       	if(pos=='fea_f_'){
			document.getElementById('errorHandle').value = 'fea_f_'+id;
			document.getElementById('fea_f_'+id).innerHTML='<img width="43" height="11" src="<?php echo base_url();?>asset/images/images/ajax-loader.gif"/>';
		}
		
		if(pos=='cou_f_'){
			document.getElementById('errorHandle').value = 'cou_f_'+id;
			document.getElementById('cou_f_'+id).innerHTML='<img width="43" height="11" src="<?php echo base_url();?>asset/images/images/ajax-loader.gif"/>';
			document.getElementById('loader').style.display='';
			document.getElementById('friend').style.display='none';			
		}
		if(pos=='int_f_'){
			document.getElementById('errorHandle').value = 'int_f_'+id;
			document.getElementById('int_f_'+id).innerHTML='<img width="43" height="11" src="<?php echo base_url();?>asset/images/images/ajax-loader.gif"/>';
		}
		
		$.ajax({type: "get",url:"<?php echo site_url()?>follow/"+id+"/"+name, success: onCheck,async: false});
	}

function onCheck(response){//alert(response);
	
	mat = " #F#F# ";
	kat = "###";
	if(response.match(mat)){
		
		var array = new Array();
		array = response.split(mat);
		//alert(array);
		document.getElementById('total_credit').innerHTML = array[2];	
		if(array[3]){
			alert(array[2]);
		}
		try{
		//alert(array[0]);
		document.getElementById('fea_f_'+array[0]).innerHTML = "<div class='type2'>Following</div>";	
		}catch(err){
		}
		
		try{
			
			document.getElementById('cou_f_'+array[0]).innerHTML = "<font style=\"font-weight:bold;color:#57861E\">Following</font>";	
			document.getElementById('loader').style.display='none';
			document.getElementById('friend').style.display='';
			document.getElementById('friend').innerHTML='<font style=\"font-weight:bold;color:#01567D\">You followed '+array[1]+'</font>';
			document.getElementById('skip'+array[0]).style.display='none';
			
		}catch(err){
		}
		
		try{
			document.getElementById('int_f_'+array[0]).innerHTML = "Following";	
		}catch(err){
		}
	
	}else if(response.match(kat)){
	
	    var array = new Array();
		array = response.split(kat);		
		document.getElementById('total_credit').innerHTML = array[2];
		document.getElementById('cou_f_'+array[0]).innerHTML = "<font style=\"font-weight:bold;color:#57861E\">Following</font>";	
	    document.getElementById('loader').style.display='none';
		document.getElementById('friend').style.display='';
		document.getElementById('friend').innerHTML='<font style=\"font-weight:bold;color:#01567D\">You followed '+array[1]+' again !!</font>';
		document.getElementById('skip'+array[0]).style.display='none';
	
	}else{
		
		
		var poss = document.getElementById('errorHandle').value;
		document.getElementById(poss).innerHTML = '<h4 style="color:red;">Error</h4>';
		var array = new Array();
		array = poss.split('_');
		if(array[0]=='cou'){
		document.getElementById('loader').style.display='none';
		document.getElementById('friend').style.display='';
		document.getElementById('friend').innerHTML='<h4 style="color:red;">Error</h4>';
		}
	}	
	}
	function skip(id){

$.ajax({type: "get",url:"<?php echo site_url()?>tweet/skip/"+id, success: skip_response,async: false});

}

function skip_response(response){

document.getElementById('skip'+response).style.display='none';

}

function retweet(id){

document.getElementById('retweet_Button'+id).innerHTML='<img src="<?php echo base_url();?>asset/images/ajax_new.gif"/>';
$.ajax({type: "get",url:"<?php echo site_url()?>tweet/retweet/"+id, success: retweet_response,async: false});

}

function retweet_response(response){

array = response.split('#');
document.getElementById('total_credit').innerHTML = array[2];
if(array[0]==0)
document.getElementById('retweet_Button'+array[1]).innerHTML='<h4 style="color:red;">Error</h4>';
else
document.getElementById('skip'+array[1]).style.display='none';

}
function doSearch(page){
	        window.location = "<?=base_url();?>summary/<?=$submenu?>/"+page;
		}
</script>

<body>
<input name="errorHandle" id="errorHandle" type="hidden"  />

<!--hader_image_srt-->
<?php $this->load->view('common/header_image')?>
<!--hader_image_end-->

<!--manu_div_srt-->
<?php $this->load->view('common/profile_menu')?>

<!--manu_div-end-->

<div class="clr" style="margin-top:70px;"></div>



<div class="clr"></div>
<div class="big_main"><!--big_main_srt-->

<div class="bigbox_div_left"><!--bigbox_div_left_srt-->





<div class="box_Sponsored">

	
	<p class="credit_text">Your Credit History</p>
	
	<div class="clr"></div>
	<div class="manu_4" style="margin-left:110px;">
	
		<ul>
		
			<li><a class="<?php if($submenu=="follow"){?> active1<?php }?>" href="<?php echo site_url()?>summary/follow">Follow</a></li>
			<li><a class="<?php if($submenu=="retweet"){?> active1<?php }?>" href="<?php echo site_url()?>summary/retweet">Retweet</a></li>
			<li><a  class="<?php if($submenu=="all"){?> active1<?php }?>" href="<?php echo site_url()?>summary">All</a></li>
		
		</ul>
	
	</div>
    <div class="clr"></div>
	<?php 
	if($summary){
	foreach($summary as $list){

	switch($list->activity){ 
	case 'follow' :

   if($list->user1 == $this->session->userdata('userid')){
   
   $profile_image = $list->profile_image2;
   $account_name = $list->account2;
   $text= '<a href="http://twitter.com/'.$account_name.'" target="_blank" style="font-weight:bold;color:#000000">'.$account_name.'</a> followed you for '.$list->bonus_credit.' credits';
   $user_credit = $list->user1_credit;
   
   }else{
   
   $profile_image = $list->profile_image1;
   $account_name = $list->account1;
   $text = 'you followed <a href="http://twitter.com/'.$account_name.'" target="_blank" style="font-weight:bold;color:#000000">'.$account_name.'</a> for '.$list->bonus_credit.' credits';
   $user_credit = $list->user2_credit;
   
   }

   break;

case 'retweet' :

   if($list->user1 == $this->session->userdata('userid')){
   
   $profile_image = $list->profile_image2;
   $account_name = $list->account2;
   $text= '<a href="http://twitter.com/'.$account_name.'" target="_blank" style="font-weight:bold;color:#000000">'.$account_name.'</a> retweeted your tweet <font color=\"#9AC58B\">'.$list->text.'</font> for '.$list->bonus_credit.' credits';
   $user_credit = $list->user1_credit;
   
   }
    break;
	}
   ?>
   <div id="skip">
 <a href="http://twitter.com/<?=$account_name?>" title="<?=$account_name?>" target="_blank"><img src="<?=$profile_image?>" alt="" width="52" height="48" style="margin:20px 5px 0 20px; float:left;" /></a>
<p class="grow_text"><?=addAcronym($text)?><p class="grow1_text"><?=addAcronym($user_credit)?></p>
<div class="clr"></div>

</div>
<?php }//}?>
	<div class="Results_text">					
						
						<table><tr>
			  
				 <td style="border:none; width:110px; font-size:12px">
				  Results <? echo $start+1;?> - <? echo ' '.$end_result;?> of <? echo $total_results;?>
				 </td>
				 <td style="text-align:center; width:auto; padding-right: 20px; border:none; font-size:12px"> Page 
				 <? if(($current_page-1) > 0 && ($current_page-1) <= $total_page ){?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page-1; ?>')">Previous</a> <? } ?>
				 <? if(($current_page-2) > 0 && ($current_page-2) <= $total_page ){?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page-2; ?>')"><? echo $current_page-2; ?></a><? } ?>
				 <? if(($current_page-1) > 0 && ($current_page-1) <= $total_page ){?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page-1; ?>')"><? echo $current_page-1; ?></a><? } ?>
				 <? if(($current_page) > 0 && ($current_page) <= $total_page ){?><? echo $current_page; ?><? } ?>
				 <? if(($current_page+1) > 0 && ($current_page+1) <= $total_page ){?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page+1; ?>')"><? echo $current_page+1; ?></a><? } ?>
				 <? if(($current_page+2) > 0 && ($current_page+2) <= $total_page ) {?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page+2; ?>')"><? echo $current_page+2; ?></a><? } ?>
				 <? if(($current_page+1) > 0 && ($current_page+1) <= $total_page ){?><a href="javascript:void(0)" onclick="doSearch('<? echo $current_page+1; ?>')">Next</a><? } ?>
				 </td>
				 
				 </tr></table>
				</div>

<?php }?>	
	
<div class="clr"></div>

</div>


</div><!--bigbox_div_left_end-->


<div class="bigbox_div_right"><!--bigbox_div_right_srt-->

 
 <div class="Credits_bg1"><!--Credits_bg-->
 
 	<h1>125</h1>
	<h2>Your Credits</h2>

 </div><!--end Credits_bg-->







</div><!--bigbox_div_right_end-->
<div class="clr"></div>

</div><!--big_main_end-->

<!--futter_bg_end-->
<?php $this->load->view('common/footer')?>
<!--futter_bg_end-->
</body>
</html>
