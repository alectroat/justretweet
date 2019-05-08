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
function follow(id,name,pos)
	{ 	//alert(pos);
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
	function skip(id){

$.ajax({type: "get",url:"<?php echo site_url()?>tweet/skip/"+id, success: skip_response,async: false});

}

function skip_response(response){

document.getElementById('skip'+response).style.display='none';

}

function retweet(id){

document.getElementById('retweet_Button'+id).innerHTML='<img src="<?php echo base_url();?>asset/images/ajax_new.gif"/>';
$.ajax({type: "get",url:"<?php echo site_url()?>tweet/retweet/"+id, success: retweet_response,async: false});

}

function retweet_response(response){

array = response.split('#');
document.getElementById('total_credit').innerHTML = array[2];
if(array[0]==0)
document.getElementById('retweet_Button'+array[1]).innerHTML='<h4 style="color:red;">Error</h4>';
else
document.getElementById('skip'+array[1]).style.display='none';

}

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

<div class="bigbox_div_left"><!--bigbox_div_left_srt-->



<div class="week_div">
<div class="box_Sponsored">


<div class="small_bx6_div">
	 <div class="small_bx_lft"></div>
        <div class="small_bx_rx">
		
		<p class="write">Feature Members</p>
		
		</div>
		<div class="small_bx_rt"></div>


</div>




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

<div class="box_Sponsored">

	<h5>Most recent tweets...</h5>
	<br/><br/>
	<?php 
	if($retweets){
	$i=0;
	foreach($retweets as $list){
	if($follower>=$list->total_member_required){
	$i++;
	?>
	<div class="Credits_con" id="skip<?=$list->tweet_id?>">
	<div class="imag"><img  src="<?=$list->profile_image?>" alt="" /></div>
	<p class="text2"><a href="http://www.twitter.com/<?=$list->account?>" target='_blank'><span>@<?=$list->account?></span></a> offered <?=$list->credit_per_tweet?> to retweet this message</p>
		<p class="text3"><?=addAcronym($list->tweet)?></p>
		<div class="manu_3">
		
			<ul>
				
								<li><a href="javascript:void(0)" onclick="skip('<?=$list->tweet_id?>');">Skip this</a></li>
												<li id="retweet_Button<?=$list->tweet_id?>"><a  href="javascript:void(0)" onclick="retweet('<?=$list->tweet_id?>');" class="boder">Schedule Retweet</a></li>
			</ul>
		
		</div>
	
	</div>
	<div class="clr"></div>
	<div class="border_bot"></div>
	<?php }
if($i==6)break;
}}?>
	
	
	
	
	
	
	
	
	
	
	
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



	<?php if($featured_users->num_rows()){?>
	
				<div class="small_bx5_div">
     	 		<div class="small_bx_lft"></div>
        		<div class="small_bx_rx" style="width:270px;">
				<p class="write">Featured Member</p>
				</div>
				<div class="small_bx_rt"></div>
				</div>
	
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
<div style="width:78px; height:19px; float:left; margin:5px 5px 0 8px;">
				<?php if($this->session->userdata('userid')){
											if($this->session->userdata('userid')!=$list->userid){
											?>
				<?php if(!in_array($list->account,$mimic)){//d($list,1); ?>
											
											<div id="fea_f_<?php echo $list->acc_id?>"><a href="javascript:void(0)" onclick="follow('<?php echo $list->acc_id?>','<?php echo $list->account?>','fea_f_')"><img src="<?php echo base_url();?>asset/images/images/batton_flow.jpg"/></a></div>
											<?php }else{?>
											<div class="type2">Following</div>
											<?php }?>
											
											<?php }else{?>
											
											<div class="type2">That's You</div>
											
											<?php }}else{?>		
											
											<div><a href="#" onclick="javascript: chk();"><img src="<?php echo base_url();?>asset/images/batton_flow.jpg" alt="" /></a></div>
											<?php }?>
				</div>
<?php if(!in_array($list->account,$mimic) and $this->session->userdata('userid')!=$list->userid){?><div id="ggg_<?php echo $list->account?>"  style="margin:5px 0 0 8px; color:#0a5c9e; ">for <?=$list->offered_credit?> Credits</div><?php }?><div style="clear:both"></div>

</div><!--basic_div_end-->

<?php 
				$i++;
				if($i==3)break;
				}?>




</div>
<!--bigbox_div_right_end-->
<div class="clr"></div>

</div><!--big_main_end-->

<!--futter_bg_end-->
<?php $this->load->view('common/footer')?>
<!--futter_bg_end-->
</body>
</html>
