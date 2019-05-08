<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?></title>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/960.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/text.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/blue.css" />
<link type="text/css" href="<?= base_url()?>asset/css/smoothness/ui.css" rel="stylesheet" />
<script src="<?= base_url()?>asset/js/jquery-1.4.2.js" type="text/javascript"></script>
  
<link type="text/css" href="<?= base_url()?>asset/css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?= base_url()?>asset/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript">
    $(function(){
       
        $('#datepicker').datepicker({
	inline: true
	});
    });
</script>
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->      

  	<!--LOGO-->
	<div class="grid_8" id="logo">Retweet Administration</div>
    <div class="grid_8">
<!-- USER TOOLS START -->
      <div id="user_tools"><span> Welcome Admin  |  <a href="<?= site_url('logout') ?>">Logout</a></span></div>
    </div>
<!-- USER TOOLS END -->    
<div class="grid_16" id="header">
<!-- MENU START -->
<?php $this->load->view('admin/admin_menu')?>
<!-- MENU END -->
</div>
<div class="grid_16">
<!-- TABS START -->
    <div id="tabs">
         <div class="container">
            <ul>
                       <li><a href="<?=site_url()?>/admin/package" class="current"><span>Package</span></a></li>
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Add Account </h1>
    </div>
	
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed"> &nbsp;<a href="<?=site_url()?>admin/setting" style="padding-left:850px;">Back</a></div>
		<div class="portlet-content nopadding">
		
         <form name="frmAddName" method="post" action="<?php echo site_url();?>admin/setting/save" enctype="multipart/form-data">
		  <center><?php if($this->validation->error_string){ ?>
		<div class="validation_error"><?php echo $this->validation->error_string; ?></div>
		<?php } ?></center>
		  <table border="0" width="100%" align="center">
		    <tr>
		    <td colspan="2"><center><?php if($success){ ?><?= $success ?><?php } ?></center></td>
		   </tr>
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td style="padding-left:270px;">Account Name :&nbsp;</td>
			<td width="58%"><input type="text" name="account_name" id="account_name" value="" /></td>
		   </tr>
				   
		   
		   
		   
		   

		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td>&nbsp;</td>
			<td>
			<input type="submit" name="submit" value="Submit" />&nbsp;
			<input type="button" name="back" value="Back" onclick="history.go(-1);" /></td>
		   </tr>
		  </table>
		 </form>
		
		</div>
      </div>
<!--  END #PORTLETS -->  
   </div>
    <div class="clear"> </div>
<!-- END CONTENT-->    
  </div>
<div class="clear"> </div>

		<!-- This contains the hidden content for modal box calls -->
		
</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<div class="container_16" id="footer">
Website Administration Share by <a href="#">Retweet</a></div>
<!-- FOOTER END -->
</body>
</html>
