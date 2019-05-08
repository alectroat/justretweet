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
<?php $this->load->view('common/menu')?>
<!--manu_div-end-->

<div class="clr" style="margin-top:70px;"></div>

<div class="main_box"><!--main_box_first-->
<div class="box_1"><!--box_1_frt-->


    <div class="box_left"></div>
               <div class="box_rx"><!--box_rx_srt-->
			          
<div class="small_bx_div">
       
	    <div class="small_bx_lft"></div>
        <div class="small_bx_rx">
		
		<p class="write">Write a message to share</p>
		
		</div>
		<div class="small_bx_rt"></div>
		
</div>
	
		 <div class="read_div">
	 <p class="user">Users earn to credite when they retweet your message profile</p>
	 </div>
	 
	   <div class="assing_div">
	   
	   <p class="assing">Assgin more credits to your message and attact more users to retweet its. </p>
	   
	   </div>

	   
</div><!--box_rx_end-->
               <div class="box_right"></div>

</div><!--box_1_end-->


<div class="box_2"><!--box_2_frt-->

            <div class="box_left"></div>
              <div class="box_rx">
			  
			  
<div class="small_bx2_div">
       
	    <div class="small_bx_lft"></div>
        <div class="small_bx_rx" style="width:125px;">
		
		<p class="write">Refer a Friend</p>
		
		</div>
		<div class="small_bx_rt"></div>
</div>
	 
	 <div class="read_div">
	 <p class="user">Users earn to credite when they retweet your message profile</p>
	 </div>
	 
	   <div class="assing_div">
	   
	   <p class="assing">Assgin more credits to your message and attact more users to retweet its. </p>
	   
	   </div>
	   
</div>
<div class="box_right"></div>

</div><!--box_2_end-->

<div class="box_3"><!--box_3_frt-->


              <div class="box_left"></div>
              <div class="box_rx">
			  
	  <div class="small_bx3_div">
       
	    <div class="small_bx_lft"></div>
        <div class="small_bx_rx" style="width:72px;">
		
		<p class="write">Sign Up</p>
		
		</div>
		<div class="small_bx_rt"></div>

</div>
			  

 
 
 	 <div class="read_div">
	 <p class="user">Users earn to credite when they retweet your message profile</p>
	 </div>
	 
	   <div class="assing_div">
	   
	   <p class="assing">Assgin more credits to your message and attact more users to retweet its. </p>
	   
	   </div>
 </div>
 
 <div class="box_right"></div>
 
 			  
			  
</div><!--box_3_end-->

</div><!--main_box_end-->

<div class="clr"></div>
					
<div class="big_main"><!--big_main_srt-->

<div class="bigbox_div_left"><!--bigbox_div_left_srt-->

	<div class="msgBox" id="msgBox" style="display:none;  margin-right: 25px;  margin-top: -12px; border:1px solid #ff0000;color:#ff0000; padding:5px; width:330px; float:right;">
					<div class="msgBoxContent" id="msgBoxContent"></div>
				</div>

<div class="week_div">
<div class="box_Sponsored">
			

<a href="#"><div class="small_bx6_div">
	 <div class="small_bx_lft"></div>
        <div class="small_bx_rx">
		
		<p class="write">Write a message to share</p>
		
		</div>
		<div class="small_bx_rt"></div>


</div></a>




<div class="clr"></div>  


    <div class="follow_11">
	<?php 
		$i=0;
		$j=0;
		$users = $featured_users->result();
		for($i=0;$i<16;$i++)
		{
			if($users[$i]->account)
			{?>
				<div class="follow">
					<img src="<?php echo $users[$i]->profile_image?>" style="margin-left:15px;" alt="" />
					<a style="color:#3F94CD;" href="http://twitter.com/<?php echo $users[$i]->account?>" target="_blank">
					<div class="type"><?php if(strlen($users[$i]->account)>11){ echo substr($users[$i]->account,0,9).'..';} else{ echo $users[$i]->account;}?></div></a>
					<div class="type2">Featured</div>
					<div class="type3"><?=$users[$i]->offered_credit?> Credits</div>
					<?php if($this->session->userdata('userid')){
					if($this->session->userdata('userid')!=$users[$i]->userid){
					?>
					<?php if(!in_array($users[$i]->account,$mimic)){?>
					<a onclick="follow('<?php echo $users[$i]->account?>','fea_f_')"><img src="<?php echo base_url();?>asset/images/images/flo_bott.jpg" alt="" /></a>
					<?php }else{?>
					<div class="type2">following</div>
					<?php }?>
					<?php }else{?>
					<div class="type2">That's you</div>
					<?php }}else{?>	
					<a href="#" onclick="javascript: chk();"><img src="<?php echo base_url();?>asset/images/batton_flow.jpg" alt="" /></a>
					<?php }?>
				</div>
	  <?php }else {?>
	  			<div class="follow">
					<img src="<?php echo base_url()?>asset/images/foll_image.jpg" style="margin-left:15px;" alt="" />
					
					<div style="color:#6bb83a; text-align:center;line-height:18px; margin-top:10px;">Featured</div>
				<?php if($this->session->userdata('userid')){?>
		        <div align="center" style="margin-top:5px;"><a href="<?php echo site_url('feature')?>"><img src="<?php echo base_url()?>asset/images/images/buy.jpg" alt="" /></a>							   				</div>
				<?php }else{?>
				   <div align="center" style="margin-top:10px;"><a href="#" onclick="javascript: ch();"><img src="<?php echo base_url()?>asset/images/images/buy.jpg" alt="" /></a>				 					</div>
				<?php }?>
				   </div>
  <?php } }?>
	

     </div>

 


<div class="clr"></div>

</div>

</div>

<div class="box_Sponsored">


<a href="#"><div class="small_bx6_div">
	 <div class="small_bx_lft"></div>
        <div class="small_bx_rx">
		
		<p class="write">See who's here...</p>
		
		</div>
		<div class="small_bx_rt"></div>


</div></a>




<div class="clr"></div>  


    <div class="follow_11">
	<?php foreach($latest_users as $list){?>
		<div class="who" style="float:left;margin:6px">
		<div align="center" style="margin-top:0px">
			<div style="width:70px;border:1px solid #62A0C1;">
		<a title="<?=$list->account?>" href="http://www.twitter.com/<?=$list->account?>" target="_blank"><img style="margin:2px;" src="<?=$list->profile_image?>"/></a>
		<div class="type2"><?=$list->follower?></div>
		<div class="type3">Followers</div>
		</div>
		</div>
		</div>
	<?php }?>	
	</div>


<div class="clr"></div>

</div>


</div>


</div><!--bigbox_div_left_end-->

<!--bigbox_div_right_srt-->
<div class="bigbox_div_right1" style="margin:10px 0 0 10px; ">
		<?php if($adds){?>
         <div class="the_sim"><!--the_sim_srt-->
		
		    <div style="height:125px; width:125px; float:left;"><a href="<?=$adds[0]->banner_link?>" target='_blank'>
				<img height="125px" width="125px" src="<?=site_url()?>asset/images/upload/img_<?=$adds[0]->banner_id?>_<?=$adds[0]->banner_img?>"/>
				</a></div>
		    <div style="height:125px; width:125px; float:right;"><a href="<?=$adds[1]->banner_link?>" target='_blank'>
				<img height="125px" width="125px" src="<?=site_url()?>asset/images/upload/img_<?=$adds[1]->banner_id?>_<?=$adds[1]->banner_img?>"/>
				</a></div>
</div><!--the_sim_end-->


<div class="clr"></div>
	  <div class="studio_div">
             <div style="height:125px; width:125px; float:left;"><a href="<?=$adds[2]->banner_link?>" target='_blank'>
				<img height="125px" width="125px" src="<?=site_url()?>asset/images/upload/img_<?=$adds[2]->banner_id?>_<?=$adds[2]->banner_img?>"/>
				</a></div>
		    <div style="height:125px; width:125px; float:right;"><a href="<?=$adds[3]->banner_link?>" target='_blank'>
				<img height="125px" width="125px" src="<?=site_url()?>asset/images/upload/img_<?=$adds[3]->banner_id?>_<?=$adds[3]->banner_img?>"/>
				</a></div>
     </div>
	 
	 
<div class="clr"></div>
 
  	
	<?php }?>
<div class="clr"></div>
    <div class="market_div">
	     <div class="market"></div>
	</div>
	<?php if($featured_users->num_rows()){?>
		<a href="#">
				<div class="small_bx5_div">
     	 		<div class="small_bx_lft"></div>
        		<div class="small_bx_rx" style="width:270px;">
				<p class="write">Featured Member</p>
				</div>
				<div class="small_bx_rt"></div>
				</div>
		</a>
	<?php }?>

<div class="clr"></div>
		<?php 
				$i=0;
				foreach($featured_users->result() as $list){				
				?>		
<div class="basic_div"><!--basic_div_srt-->
       <div class="basic_bx">
        	<div style="width:40px; height:48px; float:left; margin-top:15px;"><img src="<?=$list->profile_image?>"/></div>
       </div>

<div class="basic_fnt_d"><!--basic_fnt_d_srt-->
<div class="basic_fnt"><?=$list->account?></div>

<div style="font-size:10px;margin-bottom:5px"><div style="float:left"><img src="<?php echo base_url();?>asset/images/icons/twitterim.gif"/></div><div style="float:left;margin-left:10px"><a style="color:#0171B9" href="http://twitter.com/<?=$list->account?>">@<?=$list->account?></a></div></div>
<div style="clear:both"></div>
<div style="font-size:10px;margin-top:3px"><div style="float:left"><img src="<?php echo base_url();?>asset/images/icons/globe.gif"/></div><div style="float:left;margin-left:10px"><a style="color:#0171B9" href="<?=addAcronym($list->url);?>"><?=addAcronym($list->url);?></a></div></div>

</div><!--basic_fnt_d_end-->
<div class="clr"></div>
<div class="basic_fnt"><?=$list->description?></div>


<div style="width:78px; height:19px; float:left; margin:15px 10px 0 8px;"><a href="#" onclick="javascript: chk();"><img src="<?php echo base_url();?>asset/images/batton_flow.jpg" alt="" /></a></div>

<?php if(!in_array($list->account,$mimic) and $this->session->userdata('userid')!=$list->userid){?><div id="ggg_<?php echo $list->account?>"  style="margin:15px 0 0 8px; color:#0a5c9e; ">for <?=$list->offered_credit?> Credits</div><?php }?><div style="clear:both"></div>

</div><!--basic_div_end-->

<?php 
				$i++;
				if($i==3)break;
				}?>



</div><!--bigbox_div_right_end-->
<div class="clr"></div>

</div><!--big_main_end-->


	<!--end foter_top_rx-->

<!--futter_bg_end-->
<?php $this->load->view('common/footer')?>

<!--futter_bg_end-->
</body>
</html>
