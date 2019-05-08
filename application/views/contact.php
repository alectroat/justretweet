<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />

</head>
<body>

<!--hader_image_srt-->
<?php $this->load->view('common/header_image')?>
<!--hader_image_end-->

<!--manu_div_srt-->
<?php $this->load->view('common/menu')?>
 <!-- manu_div-end --> 

<div class="clr" style="margin-top:60px"></div>

<div class="how_con"><!--how_con-->

	<div class="how_con_m">
	<p class="type4">Contact Details</p>
	
	<p class="type6">Please see our comprehensive <span style="font-weight:bold;">Q & A</span> first, if you have any questions.<br />
In case you can’t find what you are looking for, you can also write us an e-mail: <span>info@justretweet.com</span>
<br />
We aim for answering all e-mails within 24 hours.<br />
<br />
or
<br />

leave a comment here...

</p>
	
	<div class="contact_box">
	
		<div class="contact_box_left">
		
			<p class="text">Name:</p>
			
			<p class="text">Email:</p>
			
			<p class="text">Comment:</p>
			
		</div>
		<div class="contact_box_right">
		
			<div class="contact_search">
				<input type="text" value="" class="sea" />
			</div>
			
			
			<div class="contact_search">
				<input type="text" value="" class="sea" />
			</div>
			
			<div class="contact_search1">
			  <textarea style="width: 370px; height: 138px; margin:10px 0 0 10px;border:none; background:none; " name="comment"></textarea>
			</div>
			
			<input type="button" class="post" />
		
		</div>
	
	</div>
	
<br />
<br />
<br />
<br />

<div class="clr"></div>
	</div>

</div><!--end how_con-->

<div class="clr"></div>
<!--futter_bg_start-->
<?php $this->load->view('common/footer')?>
<!--futter_bg_end-->
</body>
</html>
