<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?=base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url();?>asset/js/popup.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var tweet;
var sum;
var value00;
var value2;
var total;
var s;
function loadFunction(){
tweet = $('#detail').val().length;
sum=tweet;
total=120;
s='(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">'+total+'</span> characters left)';
document.getElementById('char_counts').innerHTML=s;
}

function loadFunctions(){
tweet = $('#details').val().length;
sum=tweet;
total=120;
s='(You have <span id="tweet_charss" style="font-size:12px; color:#00cc00;">'+total+'</span> characters left)';
document.getElementById('char_countss').innerHTML=s;
}

function calSum(){
tweet = $('#detail').val().length;
value00=document.getElementById('detail').value;
sum=total-tweet;
if(sum>=0){
value2=document.getElementById('detail').value;
}
if(sum<=0){
document.getElementById('detail').value=value2;
tweet = $('#detail').val().length;
sum=total-tweet;
}

s='(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">'+sum+'</span> characters left)';
document.getElementById('char_counts').innerHTML=s;
}

function calSums(){
tweet = $('#details').val().length;
value00=document.getElementById('details').value;
sum=total-tweet;
if(sum>=0){
value2=document.getElementById('details').value;
}
if(sum<=0){
document.getElementById('details').value=value2;
tweet = $('#details').val().length;
sum=total-tweet;
}

s='(You have <span id="tweet_charss" style="font-size:12px; color:#00cc00;">'+sum+'</span> characters left)';
document.getElementById('char_countss').innerHTML=s;
}


function editMe(website_id){
document.getElementById('website_id').value = website_id;
document.getElementById('titles').value = document.getElementById('title'+website_id).value;
document.getElementById('urls').value = document.getElementById('url'+website_id).value;
//document.getElementById('details').value = document.getElementById('detail'+website_id).innerHTML;
document.getElementById('cpv').value = document.getElementById('creditPV'+website_id).value;
document.getElementById('tc').innerHTML = '* you have '+document.getElementById('totalC'+website_id).value+' credits left';
//var sum=120-$('#details').val().length;
//s='(You have <span id="tweet_charss" style="font-size:12px; color:#00cc00;">'+sum+'</span> characters left)';
//document.getElementById('char_countss').innerHTML=s;
loadPopup();
}

function deleteMe(website_id){
var ok=confirm("Are you sure?");
		if(ok){	
		$.ajax({type: "POST",url:"<?=site_url()?>setting/deleteSites/"+website_id,success: resultTweets,async: false});
		}
}

function resultTweets(response)
	{ 	
		arr = response.split("---");
		document.getElementById('sites'+arr[0]).style.display='none';
		document.getElementById('total_cred').innerHTML=arr[1];
	}


$(document).ready(function(){
   
    $(".top_menu ul li").mouseover(function() { $(this).addClass("over");}).mouseout(function() { $(this).removeClass("over");});
	
});

</script>
</head>
<body onload="loadFunction();loadFunctions();"><!--hader_image_srt-->
<input name="errorHandle" id="errorHandle" type="hidden"  />

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

		<?php if(isset($errorMsg) && $errorMsg!=''){?>
				<div class="msgBox" id="msgBox" style="border:1px solid #ff0000; -moz-border-radius:5px; color:#ff0000; padding:5px; width:500px;">
					<div class="msgBoxContent" id="msgBoxContent"><?=$errorMsg?></div>
				</div>
				<?php }?>
				<?php if(isset($successMsg) && $successMsg!=''){?>
				<div class="msgBox" id="msgBox" style="border:1px solid #00ff00; -moz-border-radius:5px; color:#00ff00; padding:5px; width:500px;">
					<div class="msgBoxContent" id="msgBoxContent"><?=$successMsg?></div>
				</div>
				<?php }?>
	<div class="clr"></div>
	<!--Start settings menu-->
	<?php $this->load->view('common/settings_menu')?>
	<!--End settings menu-->
	<div class="clr"></div>
	<div class="mail_box">
		<?php if($accounts->num_rows() >0){ ?>
														
														
														
														<form method="post" name="frmReg" action="<?=site_url('setting/websites')?>">
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
	<div class="tweet_text1">Title of your website</div>		
			<div class="mail_1box2">
			
				<input type="text" class="sea_in3"  name="title" id="title"  value="<?php echo isset($_POST['title']) ? $_POST['title'] : '';?>" />
			
			</div>
			<?php if(isset($this->validation->title_error) && $this->validation->title_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->title_error?></span>
																	</div>
															<?php }?>
			
	<p class="tweet_text1">Your website (Most start with http:// )</p>		
			<div class="mail_1box2">
			
				<input type="text"class="sea_in3" name="url" id="url"  value="<?php echo isset($_POST['url']) ? $_POST['url'] : '';?>" />
			
			</div>	
			<?php if(isset($this->validation->url_error) && $this->validation->url_error!=''){?>
																	<div class="header_box2">
																		<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->url_error?></span>
																	</div>
															<?php }?>
			
		<div class="mail_box_ri">
	<p class="tweet_text1">Brief description of your website (Max 120 characters)</p>	

		<div class="mail_2box3">
			<textarea style="width: 540px; height:65px; border:none; background:none; margin:5px 0 0 5px; background-image: url(bg.gif); background-position: bottom right;
	background-repeat: no-repeat;" class="input" name="detail" id="detail" onkeyup="calSum();" onkeypress="calSum();" onchange="calSum();"><?php echo isset($_POST['detail']) ? $_POST['detail'] : '';?></textarea>
			</div>
<div class="tweet_text1" id="char_counts">(You have <span id="tweet_chars" style="font-size:12px; color:#00cc00;">120</span> characters left)</div>

			
			<div class="update" style="margin-left:20px;">
<input type="submit" value="Submit" name="submit" style=" width:90px; height:32px; line-height:32px; border:none; background:none; color:#333333; cursor:pointer" />
			</div>
		
		</div>
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
														<?php if($sites){?>
															<div class="header_box" style="float:left;">
																<div class="header_box_left" style="width:600px;margin-left:20px">
																
																<div style="width:100px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Image</div>
																<div style="width:240px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Url</div>
																
																
																<div style="width:90px; height:23px;float:left;background-color:#1183C2;text-align:center;padding-top:7px;color:#ffffff;font-weight:bold">Action</div>
																</div>
														    </div><div class="clear">&nbsp;</div>
															
															<?php foreach($sites as $value){?>
															<div id="sites<?=$value->website_id?>">
															<br/>															
															<div class="header_box" style="float:left;">
																<div class="header_box_left" style="width:600px;margin-left:20px">
																<div align="center" style="width:100px;float:left;margin-left:0px"><img class="thumb" height="40" width="40" src="http://wimg.ca/<?=$value->url?>" /></div>
																<div style="width:240px;float:left;margin-left:5px;padding-top:7px"><?=$value->url?></div>									
																															
																<div style="width:85px;float:left">
																<input type="button" class="edit" value="edit" onclick="editMe('<?=$value->website_id?>');"/><input type="button" class="delete" value="delete" onclick="deleteMe('<?=$value->website_id?>')"/>																
																<input type="hidden" id="title<?=$value->website_id?>" value="<?=$value->title?>"/>
																<input type="hidden" id="url<?=$value->website_id?>" value="<?=$value->url?>"/>
																<input type="hidden" id="creditPV<?=$value->website_id?>" value="<?=$value->credit_per_view?>"/>
																<input type="hidden" id="totalC<?=$value->website_id?>" value="<?=$value->total_credit?>"/>
																</div>
																</div>
														    </div><div class="clear">&nbsp;</div>
															</div>
															
															<?php }}?><br/></div>


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
