<?= $this->load->view('common/html_header');?>
   <div id="header"></div>
<script type="text/javascript" src="<?= base_url()?>/asset/js/ajaxupload.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>asset/js/date.js"></script>
<link href="<?= base_url()?>asset/css/date.css" rel="stylesheet" type="text/css" />


<script language="javascript">

function confirmation(id)
{
	var con=confirm("Do You Really Want to Delete This!");
	if(con)
	{
	window.location = "<?= site_url()?>profile/delete/"+id;
	}
}

</script>

      <div id="main_content">
	  
	   <?=$this->load->view('common/profile_menu')?>
		 <?php if($this->session->userdata('user_id')) {?>
			
			<div style="position:relative;height:250px;width:600px;left:30px;top:70px; border:1px solid #CCCCCC;">
				
				<form enctype="multipart/form-data" action="<?= site_url('profile/postmesage');?>" method="post">
				<table border="0" width="500">
				
					<tr>
						<td colspan="2">
						<?php if($error){?> <?= $error?> <?php }?>
					 
					    <?php if($success){?> <?= $success?> <?php }?>
						<?php if($this->validation->error_string){?>
			 			<?= $this->validation->error_string;?>
			  			<?php }?>
						</td>
					</tr>
					<tr>
						<td width="124">Send to..</td>
						<td width="352">
						<select id="msgid" name="msgid" style="width:205px;">
							<option value="">Select One</option>
							<?php foreach($Profile as $row){ ?>
							<option  value="<?= $row->profile_id?>"> 
							<?php echo $row->display_name;
							 }?></option>
						</select>
					  </td>
						
					</tr>
					<tr>
						<td>Write Message </td>
						<td><textarea id="message" name="message" style="width:200px; height:auto;"></textarea></td>
					</tr>
					
					<tr>
						<td>Date</td>
						<td width="352">
						<input type="text" name="date" id="featured_valid_date" class="input_all date_input datepicker_image" value="Select date" />
					  </td>
					</tr>
					<tr> <td>Time</td>	
						<td>
						
						<select id="" name="hours" >
							<option >hours</option>
							<?php $i=1;
							for($i=1;$i<=24;$i++){?>
							<option  value="<?=$i?>"><?=$i?></option>
							<?php }?>
						</select>
						
					&nbsp;	&nbsp;
					
						<select id="" name="minute" >
							<option >minute</option>
							<?php $i=0;
							for($i=0;$i<=60;$i++){?>
							<option  value="<?=$i?>"><?=$i?></option>
							<?php }?>
							
						</select>
						
						</td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="submit" name="submit" value="Post" />
						&nbsp;	&nbsp; <a href="<?= site_url('profile')?>">Cancel</a>
						</td>
					</tr>
				</table>
				</form>
			</div>
<?php }?>
		 		
		 
	
	
	
</div>
<div> <?php if($this->session->userdata('error')) {echo $this->session->userdata('error'); $this->session->sess_destroy('error');}?></div>
<?= $this->load->view('common/footer');?>

</body>
</html>
