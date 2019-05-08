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

function skip(id){

$.ajax({type: "get",url:"<?php echo site_url()?>tweet/skip/"+id, success: skip_response,async: false});

}

function skip_response(response){

document.getElementById('skip'+response).style.display='none';

}

function retweet(id){
//alert(id);
document.getElementById('retweet_Button'+id).innerHTML='<img src="<?php echo base_url();?>asset/images/ajax_new.gif"/>';
$.ajax({type: "get",url:"<?php echo site_url()?>tweet/retweet/"+id, success: retweet_response,async: false});

}

function retweet_response(response){
//alert(response);
array = response.split('#');
document.getElementById('total_credit').innerHTML = array[2];
if(array[0]==0)
document.getElementById('retweet_Button'+array[1]).innerHTML='<h4 style="color:red;">Error</h4>';
else
document.getElementById('skip'+array[1]).style.display='none';

}

$(document).ready(function(){
   
    $(".top_menu ul li").mouseover(function() { $(this).addClass("over");}).mouseout(function() { $(this).removeClass("over");});
	
});
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

<!--bigbox_div_left_srt-->
<div class="bigbox_div_left">





<div class="box_Sponsored">

	<h5>Retweet these messages to earn credit</h5>
	<?php if(isset($errorMsg) && $errorMsg!=''){?>
				<div class="msgBox" id="msgBox" style="border:1px solid #ff0000; -moz-border-radius:5px; color:#ff0000; padding:5px; width:500px;">
					<div class="msgBoxContent" id="msgBoxContent"><?php echo $errorMsg?></div>
				</div>
				<?php }?>
				<?php if(isset($successMsg) && $successMsg!=''){?>
				<div class="msgBox" id="msgBox" style="border:1px solid #00ff00; -moz-border-radius:5px; color:#00ff00; padding:5px; width:500px;">
					<div class="msgBoxContent" id="msgBoxContent"><?php echo $successMsg?></div>
				</div>
				<?php }?>
	<br/><br/>
	<?php 
		if($retweets){
		foreach($retweets as $list){
		if($follower>=$list->total_member_required){
		?>
	<div class="Credits_con" id="skip<?=$list->tweet_id?>">
	<img src="<?=$list->profile_image?>" style="float:left; margin-right:5px;" alt="" />
	<p class="text2"><a href="http://www.twitter.com/<?=$list->account?>" target='_blank'><span>@<?=$list->account?></span></a> offered <?=$list->credit_per_tweet?> to retweet this message</p>
		<p class="text3"><?=addAcronym($list->tweet)?></p>
<div class="clr"></div>

		<div class="manu_3">
			<ul>
				<li><a href="javascript:void(0)" onclick="skip('<?=$list->tweet_id?>');">Skip this</a></li>
				<li id="retweet_Button<?=$list->tweet_id?>"><a href="javascript:void(0)" class="boder" onclick="retweet('<?=$list->tweet_id?>');">Schedule Retweet</a></li>
			</ul>
		</div>
	
	</div>
	<div class="clr"></div>
	<div class="border_bot"></div>
	
			
	<?php }}}?>
	
	
	
	
	
	

	

	
<div class="clr"></div>
</div>


</div><!--bigbox_div_left_end-->

<!--bigbox_div_right_start-->
<div class="bigbox_div_right" style="margin:20px 0 0 10px; "><!--bigbox_div_right_srt-->

 
<!--Credits_bg-->
 <div class="Credits_bg"> 
 	<h1 id="total_credit"><?php echo $this->session->userdata('credit_points');?></h1>
	<h2>Your Credits</h2>
	<br/><br/>
 	<?php if(isset($account) && $account!=''){?>
					<h2 align="center"><a style="color:#FFFFFF;" href="<?php echo site_url('setting')?>">Account Setting <?php if($this->session->userdata('acc_setting')=='No'){?><br/>(Set Account and Get 25 Credits)<?php }?></a></h2><br/>
					<?php }?>
	
 </div><!--end Credits_bg-->



	


</div>
<!--bigbox_div_right_end-->
<div class="clr"></div>

</div><!--big_main_end-->

<!--futter_bg_end-->
<?php $this->load->view('common/footer')?>
<!--futter_bg_end-->
</body>
</html>
