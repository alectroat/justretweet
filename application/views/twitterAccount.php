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


	<!--Start settings menu-->
	<?php $this->load->view('common/settings_menu')?>
	<!--End settings menu-->
	<div class="clr"></div>
	<center><p class="mail_text3" style="font-size:16px; margin-top:10px;"> Total <?=$countFollower?> user followed you</p></center>
	<div class="clr"></div>
	<div class="mail_box">
	 <?php if($accounts->num_rows() >0){ ?>
	<form enctype="multipart/form-data" method="post" name="frmReg" action="<?=site_url('setting/twitter')?>">
				<?php if(isset($this->validation->email_error) && $this->validation->email_error!=''){?>
					<div class="header_box2">
					<span class="error" style="padding-left:30px; width:285px;"><?=$this->validation->email_error?></span>
					</div>
				<?php }?>
					<div class="clr"></div>
				<?php if(isset($accMSG) && $accMSG!=''){?>
        				<div class="header_box" style="float:left;">
						<span"><?=$accMSG?></span>
						</div>
					<div class="clr"></div>
					<div class="clr"></div>
				<?php }?>
				
		<div class="mail_box_le">
			<p class="mail_text">Credit*</p>
			<p class="mail_text">Active Status*</p>
			
			
		
		</div>
		<div class="mail_box_ri">
		
				<div class="mail_1box1">
			
				<select style="width:160px; height:24px; border:none; background:none; margin:4px 0 0 5px; color:#333333;" name="credit" id="credit">
				<option selected="selected" value="">Select</option>
						<?php for($i=1;$i<11;$i++){?>
							<option <?php if($offered_credit==$i){?> selected="selected"<?php }?> value="<?=$i?>"><?=$i?></option>
						<?php }?>
				</select>
			
			</div>
			
			<div class="mail_1box1">
			
				<select style="width:160px; height:24px; border:none; background:none; margin:4px 0 0 5px; color:#333333;" name="accelaration" id="accelaration">
					<option <?php if($accelaration=="ON" || $_POST['accelaration']=="ON"){?> selected="selected"<?php }?> value="ON">ON</option>
					<option <?php if($accelaration=="OFF" || $_POST['accelaration']=="OFF"){?> selected="selected"<?php }?> value="OFF">OFF</option>
				</select> 
			
			</div>
			
			
			<div class="update">
<input type="submit" name="submit" value="Update" style=" width:90px; height:32px; line-height:32px; border:none; background:none; color:#333333; cursor:pointer" />
			</div>
		
		</div>
	</form>
	<?php }else{ ?> <a href="<?=site_url('twitterapp')?>" <div class="header_box" align="center" style="width:320px;float:left;margin-left:120px;margin-bottom:10px">
														<div class="log_top"></div>
															<div class="log_content">
																
																<br/>
																<h2 align="center">Add Your Twitter Account</h2>
																<br/>
																
															</div>
															<div class="log_bottom"></div>
				</div></a> <?php }?>
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