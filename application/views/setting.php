<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?php echo base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
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
</script>
</head>
<body>
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

	
	<p class="Get_text">Get 25 Credits for every referral :</p>
	<div class="same_in1"><input type="text" name="" value="" class="sea_in2" /></div>
	<div class="clr"></div>
	<!--Start settings menu-->
	<?php $this->load->view('common/settings_menu')?>
	<!--End settings menu-->
	
	<div class="clr"></div>
	<div class="mail_box">
	<form enctype="multipart/form-data" method="post" name="frmReg" action="<?=site_url('setting')?>">
				<?php if(isset($this->validation->email_error) && $this->validation->email_error!=''){?>
					<div class="header_box2">
					<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->email_error?></span>
					</div>
				<?php }?>
				<?php if(isset($this->validation->sex_error) && $this->validation->sex_error!=''){?>
					<div class="header_box2">
					<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->sex_error?></span>
					</div>
				<?php }?>
				<?php if(isset($this->validation->country_error) && $this->validation->country_error!=''){?>
					<div class="header_box2">
					<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->country_error?></span>
					</div>
				<?php }?>
		
					<div class="clr"></div>								
				<?php if(isset($accMSG) && $accMSG!=''){?>
					
					<span"><?=$accMSG?></span>
					<div class="clr"></div>
				<?php }?>
		<div class="mail_box_le">
		
			<p class="mail_text"> Your Email*</p>
			
			<p class="mail_text"> You Are*</p>
			
			<p class="mail_text"> Country*</p>
			
			<p class="mail_text">Interests*</p>
		
		</div>
		<div class="mail_box_ri">
		
			<div class="mail_1box">
			
				<input type="text" class="sea_in1"  name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $this->session->userdata('email')?>"/>
			
			</div>
			
				<div class="mail_1box">
			
				<select style="width:278px; height:24px; border:none; background:none; margin:4px 0 0 5px; color:#333333;" name="sex" id="sex">
				<option>Select Sex</option>
				<option <?php if($this->session->userdata('sex')=="Male" || $_POST['sex']=='Male'){?> selected="selected"<?php }?> value="Male">Male</option>
				<option <?php if($this->session->userdata('sex')=="Female" || $_POST['']=='Female'){?> selected="selected"<?php }?> value="Female">Female</option>
				</select> 
			
			</div>
			
			<div class="mail_1box">
			
				<select style="width:278px; height:24px; border:none; background:none; margin:4px 0 0 5px; color:#333333;" name="country" id="country">
				<option>Select Country</option>
				<?php foreach($country_list as $row):?>
				<option <?php if($this->session->userdata('country')==$row->country_name || $_POST['country']==$row->country_name)
					{?> selected="selected"<?php }?> value="<?=$row->country_name?>"><?=$row->country_name?></option>
				<?php endforeach;?>
				</select> 
			
			</div>
			
			<div class="mail_2box">
			
			<textarea name="interest" style="width:274px; height:140px;" id="tweet" onclick="if(this.value=='Enter your comment here...') this.value=''; setbg('#e5fff3');" onblur="if(this.value=='') this.value='Enter your comment here...'; setbg('white')"><?php echo isset($_POST['interest']) ? $_POST['interest'] : $this->session->userdata('interest')?></textarea>
			</div>
			
			<p class="Interests_text">[Please use comma separator for listing multiple interests] </p>
			<div class="update">
<input type="submit" name="submit" value="Update" style=" width:90px; height:32px; line-height:32px; border:none; background:none; color:#333333; cursor:pointer" />
			</div>
		
		</div>
	</form>
	</div>
	
<div class="clr"></div>
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
