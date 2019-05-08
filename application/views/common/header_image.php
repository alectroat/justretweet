<div class="hader_image">
                <div class="main_hader">
                      <div class="logo"></div>
              <?php if(!$this->session->userdata('userid')){?>        <a href="<?php echo base_url();?>twitterapp"><div class="sign_in"></div></a><?php }?>
               </div>
	<?php if($this->session->userdata('userid')){?>
			<div class="header_right">
				
				<div style="position:relative;left:270px;top:-20px; font-size:18px;color: #0A437F">Welcome <?php echo $this->session->userdata('username');?>&nbsp;|&nbsp;<a style="color:#0171BB;" href="<?php echo site_url('logout');?>">Logout</a></div>
				<div class="clear">&nbsp;</div>
				
			</div>
		<?php }?>

</div>