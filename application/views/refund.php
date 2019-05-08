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

<!--manu_div-start-->
<?php $this->load->view('common/menu')?>

<!--manu_div-end-->

<div class="clr" style="margin-top:60px"></div>

<div class="how_con"><!--how_con-->

	<div class="how_con_m">
	<p class="type4">Refund Policy</p>
	
	<p class="type6">We offer a 100% refund option for your initial purchase. If you are not happy with the service provided you may contact us within 7 days of making the purchase and we will refund your payment. This provides you with a risk free way to trial our services.
<br />
<br />
Customers may be asked to provide a valid reason for claiming a refund.
<br />
<br />
Refunds are only available for the first purchase you make with us, and not subsequent purchases. If you make multiple purchases then only the first purchase is eligible for a refund. This is to protect us against fraud. Once a refund has been made, further purchases will not be eligible for refunds.
<br />
<br />
E-mail your refund requests to Info@JustRetweet.com. Please include the words “Refund Request” in the subject line of your e-mail.</p>
	
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
