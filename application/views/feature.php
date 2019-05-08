<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?php echo base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
   
    $(".top_menu ul li").mouseover(function() { $(this).addClass("over");}).mouseout(function() { $(this).removeClass("over");});
	
});

function follow(id,name)
	{	//alert(id);
       	document.getElementById('errorHandle').value = 'fea_f_'+id;
		document.getElementById('fea_f_'+id).innerHTML='<img src="<?=base_url();?>asset/images/images/ajax-loader.gif"/>';
		$.ajax({type: "get",url:"<?=site_url()?>follow/"+id+"/"+name, success: onCheck,async: false});
	}

function onCheck(response){
	//alert(response);
	mat = " #F#F# ";
	
	if(response.match(mat)){
		
		var array = new Array();
		array = response.split(mat);
		
		if(array[3]){
			alert(array[3]);
		}
				
		try{
		document.getElementById('fea_f_'+array[0]).innerHTML = "<div style='color:#6bb83a; text-align:center;line-height:20px;'>Following</div>";	
		}catch(err){
		}
		
	}else{
		
		alert(response)
		var poss = document.getElementById('errorHandle').value;
		document.getElementById(poss).innerHTML = '<h4 style="color:red;">Error</h4>';
	}	
	
}
</script>
<script type="text/javascript" src="<?=site_url();?>asset/js/stickytooltip.js"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url();?>asset/css/stickytooltip.css" />


</head>
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
<!--big_main_srt-->
<div class="big_main">

<div class="bigbox_div_left"><!--bigbox_div_left_srt-->





<div class="box_Sponsored">
	<?php 
		$i=0;
		$features = $fea_packages->result();
		
		for($i=0;$i<8;$i++)
		{
		if(!$features) break;
		if($features[$i]->package_duration1=="day"){$day = $features[$i]->package_duration;}
		if($features[$i]->package_duration1=="week"){$day = $features[$i]->package_duration * 7;}
		if($features[$i]->package_duration1=="month"){$day = $features[$i]->package_duration * 30;}
		if($features[$pi]->package_name){
	?>
	<div class="month_bg">
	<form style="padding:0px;margin:0px;" name="frmCheckOut" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">	
		<div class="mon_text"><?=$features[$i]->package_name?>,<?= $features[$i]->package_value?></div>
		
		<div class="get_text">Get <?= $features[$i]->bonus_points?> Credits Daily</div>
		<a href="#"><div class="gradientBoxesWithOuterShadows">Buy Now</div></a>
		 <input type="hidden" name="cmd" value="_xclick">
		 <input type="hidden" name="business" value="<?=$account_name[0]->account_name?>">
		 <input type="hidden" name="currency_code" value="USD">
		 <input type="hidden" name="no_shipping" value="1">									
		 <input type="hidden" name="notify_url" value="<?= site_url('feature/payment_notify')?>">
		 <input type="hidden" name="return" value="<?= site_url("feature/payment_success")?>">
		 <input type="hidden" name="cancel_return" value="<?= site_url("feature/payment_fail")?>">
		 <input type=hidden name="rm" value="2">                           
		 <input type=hidden name="upload" value="1">
		 <input type="hidden" value="<?= $this->session->userdata("userid").'#'.$features[$i]->package_id?>" name="custom" />
		 <input type="hidden" value="<?= $features[$i]->package_name?>" name="item_name"/>
		 <input type="hidden" value="<?= $features[$i]->package_value?>" name="amount"/>
		 <input type="hidden" value="1" name="quantity"/>
	</form>
	</div>
	<?php
	}
	}
	?>
	<?php
		$points = $point_packages->result();
		
		for($i=0;$i<8;$i++)
		{
		if(!$points) break;
		//d($points,1);
		if($points[$i]->package_name){
		?>
		<div class="month_bg">
		<form style="padding:0px;margin:0px;" name="frmCheckOut" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">	
		<div class="mon_text"><?=$points[$i]->package_name?>,<?= $points[$i]->package_value?></div>
		
		<div class="get_text">Delivered immediately</div>
	
		 <input type="hidden" name="cmd" value="_xclick">
		 <input type="hidden" name="business" value="<?=$account_name[0]->account_name?>">
		 <input type="hidden" name="currency_code" value="USD">
		 <input type="hidden" name="no_shipping" value="1">									
		 <input type="hidden" name="notify_url" value="<?= site_url('feature/payment_notify')?>">
		 <input type="hidden" name="return" value="<?= site_url("feature/payment_success")?>">
		 <input type="hidden" name="cancel_return" value="<?= site_url("feature/payment_fail")?>">
		 <input type=hidden name="rm" value="2">                           
		 <input type=hidden name="upload" value="1">
		 <input type="hidden" value="<?= $this->session->userdata("userid").'#'.$points[$i]->package_id?>" name="custom" />
		 <input type="hidden" value="<?= $points[$i]->package_name?>" name="item_name"/>
		 <input type="hidden" value="<?= $points[$i]->package_value?>" name="amount"/>
		 <input type="hidden" value="1" name="quantity"/>
		 <input type="image"  class="gradientBoxesWithOuterShadows" value="Buy Now"/>
	</form>
	</div>
	<?php
	}
	}
	?>
<div class="clr"></div>
</div>


</div><!--bigbox_div_left_end-->

<div class="bigbox_div_right" style="margin:20px 0 0 10px; "><!--bigbox_div_right_srt-->
<?php 
if($featured_users->num_rows()>0){
			?>
 <!--Credits_bg-->
<div class="featured_user"><!--Credits_bg-->
 		<?php
		foreach($featured_users->result() as $users):
		?> 
 	 <div class="featured_user_con">
 		<div class="featured_user_le">
			<img src="<?=$users->profile_image?>" alt="" />
			<a href="http://twitter.com/<?=$users->account?>" target="_blank"><p class="featured_text"><?=$users->account?></p></a>
			
		</div>
		<div class="featured_user_re">
		
		<p class="featured_text1">Featured User</p>
		<?php 
			if($this->session->userdata('userid')!=$users->userid){
		?>
		<?php if(!in_array($users->account,$mimic)){//d($users,1);?>
		<a href="javascript:void(0)" onclick="follow('<?php echo $users->acc_id?>','<?php echo $users->account?>');"><div id="fea_f_<?=$users->acc_id?>" style="margin-top:12px;left:0px;position:relative;" ><img src="<?php echo base_url();?>asset/images/flo_bott.jpg" alt=""  style="margin-top:5px;position:relative;"/></div></a>
		<?php }else{?> 
		<div style="text-align:right;"><h4 style=" font-size:14px; font-weight:bold; color:#00FF99;">Following</h4></div>
											<?php }?>
											
											
											<?php }else{?>
											
											<div style="text-align:right;"><h4 style=" font-size:14px; font-weight:bold;color:#00FF99;">That's You</h4></div>
											
											<?php }?>

		</div>
		
	</div>
	<?php endforeach;?>
	
	 	 
	
	 	 
 
<?php  }?>
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
