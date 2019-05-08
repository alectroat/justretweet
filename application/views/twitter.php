<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>asset/css/style.css" type="text/css" />
<script src="<?php echo base_url();?>asset/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
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
<script type="text/javascript" src="<?=site_url();?>asset/js/stickytooltip.js"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url();?>asset/css/stickytooltip.css" />

<script type="text/javascript">

function skip(id){
//alert(id);
$.ajax({type: "get",url:"<?php echo site_url()?>twitter/skip/"+id, success: skip_response,async: false});

}

function skip_response(response){
//alert(response);
document.getElementById('skip'+response).style.display='none';

}

$(document).ready(function(){
   
    $(".top_menu ul li").mouseover(function() { $(this).addClass("over");}).mouseout(function() { $(this).removeClass("over");});
	
});

function chk()
	{
		document.getElementById('msgBox').style.display = "";
		document.getElementById('msgBoxContent').innerHTML = 'Please Sign In Before You Follow Someone.&nbsp;<a href="<?php echo site_url('login')?>">Login Here</a>';
	}
	
function ch()
	{
		document.getElementById('msgBox').style.display = "";
		document.getElementById('msgBoxContent').innerHTML = 'Please Sign In Before You Buy Something.&nbsp;<a href="<?php echo site_url('login')?>">Login Here</a>';
	}

function follow(id,name,pos)
	{ 	//alert(id);
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

</script>
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
<div class="big_main"><!--big_main_srt-->

<div class="bigbox_div_left"><!--bigbox_div_left_srt-->



<div class="week_div">
<div class="box_Sponsored">


<div class="small_bx6_div">
	 <div class="small_bx_lft"></div>
        <div class="small_bx_rx">
		
		<p class="write">Follow and earn credit</p>
		
		</div>
		<div class="small_bx_rt"></div>


</div>




<div class="clr"></div>  


    <div class="follow_11">
	<?php 
		$i=0;
		$j=0;
		$users = $featured_users->result();
		//d($users,1);
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
					<?php if(!in_array($users[$i]->account,$mimic)){ ?>
					<div id="fea_f_<?php echo $users[$i]->acc_id?>"><a href=" javascript:void(0)" onclick="follow('<?php echo $users[$i]->acc_id?>','<?php echo $users[$i]->account?>','fea_f_')"><img src="<?php echo base_url();?>asset/images/flo_bott.jpg" alt="" /></a></div>
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

<div class="box_Sponsored"><!--box_Sponsored-->

<div class="box_Sponsored1">

	<a class="sameInterests <?php if($submenu=="interest"){?>selected <?php }?>" href="<?php echo site_url()?>twitter/interest"><div class="same_in"><p class="same_text">Same interests</p></div></a>
	
	<a class="sameCountry <?php if($submenu=="country"){?>selected <?php }?>" href="<?php echo site_url()?>twitter/country"><div class="same_co"><p class="same_text">Same Country</p></div></a>
	
<a class="all<?php if($submenu=="all"){?>selected <?php }?>" href="<?php echo site_url()?>twitter"><div class="same_all" class="active"><p class="same_text1">All</p></div> </a>
	
	<div class="clr"></div>
	<br />
	<div align="right">
	<ul>
			<li id="loader" style="margin-left:50px;margin-top:10px;display:none">
			<img  src="<?php echo base_url();?>asset/images/images/ajax-loader7.gif"/>
			 </li>
			<li id="friend" style="margin-left:50px;margin-top:10px;display:none">
			</li>
	</ul>
	
	</div>
	<br />
	<br />
	
<?php 	if($this->session->userdata('email')){
						
						if(count($follow_list)>0){
						
						
						foreach($follow_list as $list){?>

		   <div class="follow1" id="skip<?=$list->account?>">
		   		<a title="<?=$list->account?>" href="http://www.twitter.com/<?php echo $list->account?>">
   				<img style="margin-left:15px;" alt="" src="<?php echo $list->profile_image?>" data-tooltip="sticky1" class="thumb" onmouseover="showTooltip('<?=$list->id?>'); return false;" alt="<?php echo $list->account?>" /></a>
				<div class="type3"><?php echo $list->offered_credit.' Credits';?></div>
  				<div align="center" class="follow_button" id="cou_f_<?php echo $list->account?>">
					<a  href="javascript:void(0)"  onclick="follow('<?php echo $list->account?>','<?php echo $list->account_name?>','cou_f_')" ></a>
				</div>
  				<div ><a href="javascript:void(0)" style="font-size:10px" onclick="skip('<?=$list->account?>');"><p class="type_7">Skip</p></a></div>
   		   </div>
 		   <?php						
			}?>
			<div class="clear"></div>
			
				<?php }
						
						}?>

	 
	
<div class="clr"></div>
<?php 
						if($this->session->userdata('acc_setting')=='No'){?>
						<h4 style="font-size:14px;">You didn't set your account yet.&nbsp;<a href="<?php echo site_url('setting')?>">Set Your Account Here</a></h4>
						<?php }?>
</div>
</div><!--end box_Sponsored-->


</div><!--bigbox_div_left_end-->


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
