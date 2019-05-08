<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?=base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url();?>asset/js/popup.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
//var tweet_id='';
var tweet;
var sum;
var value00;
var value2;
var total;
var s;
function loadFunction(){
tweet = $('#tweet').val().length;
sum=tweet;
total=140-$('#accountHolder').val().length-5;
s='(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">'+total+'</span> characters left)';
document.getElementById('char_counts').innerHTML=s;
//loadPopup();
}

function calSum(){ 
tweet = $('#tweet').val().length;
value00=document.getElementById('tweet').value;
sum=total-tweet;
if(sum>=0){
value2=document.getElementById('tweet').value;
}
if(sum<=0){
document.getElementById('tweet').value=value2;
tweet = $('#tweet').val().length;
sum=total-tweet;
}

s='(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">'+sum+'</span> characters left)';
document.getElementById('char_counts').innerHTML=s;
}


function editMe(tweet_id){
document.getElementById('retweet_id').value = tweet_id;
document.getElementById('creditPT').value = document.getElementById('creditPT'+tweet_id).innerHTML;
document.getElementById('totalOC').innerHTML = '* you have '+document.getElementById('totalOC'+tweet_id).innerHTML+' credits left';
//document.getElementById('totalMR').value = document.getElementById('totalMR'+tweet_id).innerHTML;
loadPopup();
}

function deleteMe(tweet_id){
var ok=confirm("Are you sure?");
		if(ok){	
		$.ajax({type: "POST",url:"<?=site_url()?>setting/deleteTweet/"+tweet_id,success: resultTweet,async: false});
		}
}

function resultTweet(response)
	{ 	
	   	//alert(response);
		arr = response.split("---");
		document.getElementById('tweet'+arr[0]).style.display='none';
		document.getElementById('total_credit').innerHTML=arr[1];		
	}


$(document).ready(function(){
   
    $(".top_menu ul li").mouseover(function() { $(this).addClass("over");}).mouseout(function() { $(this).removeClass("over");});
	
});
</script>
</head>
<body onload="loadFunction();"><!--hader_image_srt-->
<?php if($this->session->userdata('userid')){?>
			
				<?php if($accounts->num_rows() >0){
				
					foreach($accounts->result() as $row): 
				?>
					<input type="hidden" id="accountHolder" value="<?=$row->account?>"><?php 
				endforeach;
				}}?>
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

	
	<div class="clr"></div>
	<!--Start settings menu-->
	<?php $this->load->view('common/settings_menu')?>
	<!--End settings menu-->
	<div class="clr"></div>
	<?php $result=$accounts->result();?>
	<p class="tweet_text">Tweet <b>( RT @<?=$result[0]->account?></b> will be added automatically to your message )</p>
	<div class="clr"></div>
	<div class="mail_box">
	<?php if($accounts->num_rows() >0){ ?>
														
														
														
														<form method="post" name="frmReg" action="<?=site_url('setting/retweet')?>">
															<?php if(isset($this->validation->email_error) && $this->validation->email_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->email_error?></span>
																	</div>
															<?php }?>
															<div class="clear">&nbsp;</div>
													
														<?php if(isset($accMSG) && $accMSG!=''){?>
																	<div class="header_box" style="float:left;">
																		<span"><?=$accMSG?></span>
																	</div>
																	<div class="clear">&nbsp;</div>
														<?php }?>
		<div class="mail_box_ri">
		
		<div class="mail_2box1">
			<input type="hidden" name="id" id="id" value="<?=$id?>" />
			<textarea style="width:536px; padding:2px; height:65px;" class="input" name="tweet" id="tweet" onkeyup="calSum();" onkeypress="calSum();" onchange="calSum();"><?php echo isset($_POST['tweet']) ? $_POST['tweet'] : '';?></textarea>
			
			</div>
			<?php if(isset($this->validation->tweet_error) && $this->validation->tweet_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->tweet_error?></span>
																	</div>
															<?php }?>
			
			<div class="tweet_text1" id="char_counts">(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">140</span> characters left)</div>
			<p class="tweet_text1">How many credits would you like to offer members who retweet this message</p>		
			<div class="mail_1boxm">
			
				<input type="text" name="credit_per_tweet" id="credit_per_tweet" value="<?php echo isset($_POST['credit_per_tweet']) ? $_POST['credit_per_tweet'] : '';?>" class="sea_in2" />
			
			</div>
			<div class="clear">&nbsp;</div>
															
															<?php if(isset($this->validation->credit_per_tweet_error) && $this->validation->credit_per_tweet_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->credit_per_tweet_error?></span>
																	</div>
															<?php }?>
			

<p class="tweet_text1">Total credits allocated for this message</p>		
			<div class="mail_1boxm">
			
				<input type="text" class="sea_in2" name="total_offered_credit" id="total_offered_credit"  value="<?php echo isset($_POST['total_offered_credit']) ? $_POST['total_offered_credit'] : '';?>" />
			
			</div>	<div class="clear">&nbsp;</div>
			<?php if(isset($this->validation->total_offered_credit_error) && $this->validation->total_offered_credit_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->total_offered_credit_error?></span>
																	</div>
															<?php }?>
<p class="tweet_text1">Set the minimum number of followers a member should have to retweet this message</p>		
			<div class="mail_1boxm">
			
				<input type="text" name="total_member_required" id="total_member_required"  value="<?php echo isset($_POST['total_member_required']) ? $_POST['total_member_required'] : '';?>" class="sea_in2" />
			
			</div>	<div class="clear">&nbsp;</div>
															
															<?php if(isset($this->validation->total_member_required_error) && $this->validation->total_member_required_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->total_member_required_error?></span>
																	</div>
															<?php }?>	
			
			<div class="update" style="margin-left:20px;">
<input type="submit" name="submit" value="Submit" style=" width:90px; height:32px; line-height:32px; border:none; background:none; color:#333333; cursor:pointer" />
			</div>
		
		</div>
		<div class="clear">&nbsp;</div>
	</form>
												
														
														<?php }else{ ?> <a href="<?=site_url('setting/twitterAccount')?>" >
														<div class="header_box" align="center" style="width:320px;float:left;margin-left:120px;margin-bottom:10px">
														<div class="log_top"></div>
															<div class="log_content">
																
																<br/>
																<h2 align="center">Add Your Twitter Account</h2>
																<br/>
																
															</div>
															<div class="log_bottom"></div>
				</div></a>
														
														<?php }?>
	
	</div>
	
<div class="clr"></div>
<br/>
														<?php if($retweets){?>
															<div class="header_box" style="float:left;">
																<div class="header_box_left" style="width:600px;margin-left:20px">
																<div style="width:380px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Retweet</div>
																
																
																<div style="width:60px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Credit</div>
																<div style="width:60px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Amount</div>
																<div style="width:90px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Action</div>
																</div>
														    </div><div class="clear">&nbsp;</div>
															
															<?php foreach($retweets as $value){?>
															<div id="tweet<?=$value->tweet_id?>">
															<br/>															
															<div class="header_box" style="float:left;">
																<div class="header_box_left" style="width:600px;margin-left:20px">
																<div style="width:380px;float:left"><?=$value->tweet?></div>
																<div id="creditPT<?=$value->tweet_id?>" align="center" style="width:60px;float:left;padding-top:7px"><?=$value->credit_per_tweet?></div>
																<div id="totalOC<?=$value->tweet_id?>" align="center" style="width:60px;float:left;padding-top:7px"><?=$value->total_offered_credit?></div>
																<!--<div id="totalMR<?=$value->tweet_id?>" align="center" style="width:45px;float:left"><?=$value->total_member_required?></div>-->
																<div style="width:90px;float:left">
																<input type="button" class="edit" value="edit" onclick="editMe('<?=$value->tweet_id?>');"/><input type="button" class="delete" onclick="deleteMe('<?=$value->tweet_id?>')" value="delete"/>
																</div>
																</div>
														    </div><div class="clear">&nbsp;</div>
															</div>
															
															<?php }}?><br/>
</div>


</div><!--bigbox_div_left_end-->


<div class="bigbox_div_right"><!--bigbox_div_right_srt-->

 
 <div class="Credits_bg1"><!--Credits_bg-->
 
 	<h1><?=$this->session->userdata('credit_points')+$this->session->userdata('todays_point')?></h1>
	<h2>Your Credits</h2>
	<br/><br/>
		<?php if(isset($account) && $account!=''){?>
		<h2 align="center"><a style="color:#FFFFFF;" href="<?=site_url('setting')?>">Account Setting<?php if($this->session->userdata('acc_setting')=='No'){?><br/>(Set Account and Get 25 Credits)<?php }?></a></h2>
		<br/>
					<?php }?>
 </div><!--end Credits_bg-->







</div><!--bigbox_div_right_end-->
<div class="clr"></div>

</div><!--big_main_end-->

<!--foter_top_rx-->
<?php $this->load->view('common/footer')?>
	
<!--futter_bg_end-->
</body>
</html>
