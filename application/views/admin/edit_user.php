<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?></title>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/960.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/text.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/blue.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>asset/css/date.css" />
<link type="text/css" href="<?= base_url()?>asset/css/smoothness/ui.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="<?= base_url()?>asset/js/jquery-1.4.2.js"></script>  
<script type="text/javascript" language="javascript" src="<?= base_url()?>asset/js/date.js"></script>
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
                      <li><a href="<?php echo site_url();?>admin/user/" class="current"><span>User List</span></a></li>
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Edit User</h1>
    </div>
	
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed"> &nbsp;</div>
		<div class="portlet-content nopadding">
		<?php
		foreach($user_info->result() as $row):
		?> 
         <form name="frmAddName" method="post" action="<?php echo site_url();?>admin/user/edit/<?=$current_page?>" onsubmit="return check();" enctype="multipart/form-data">
		  <table border="0" width="100%" align="center">
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td style="padding-left:270px;">Credit Points :&nbsp;</td>
			<td width="60%"><input type="text" name="credit_points" id="credit_points" value="<?= $row->credit_points ?>" /></td>
		   </tr>
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td style="padding-left:270px;">Featured Upto :&nbsp;</td>
			<td width="60%"><input type="text" name="featured_valid_date" id="featured_valid_date" class="input_all date_input datepicker_image" value="<?= $row->featured_valid_date ?>" /></td>
		   </tr>
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td style="padding-left:270px;">Is Featured?&nbsp;</td>
			<td width="60%">
				<select name="isFeatured" id="isFeatured">
					<option <?php if($row->isFeatured == 'Yes'){?> selected="selected"<?php }?> value="Yes">Yes</option>
					<option <?php if($row->isFeatured == 'No'){?> selected="selected"<?php }?> value="No">No</option>
				</select>
			</td>
		   </tr>
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td style="padding-left:270px;">Active Status :&nbsp;</td>
			<td width="60%">
				<select name="status" id="status">
					<option <?php if($row->status == 'Active'){?> selected="selected"<?php }?> value="Active">Active</option>
					<option <?php if($row->status == 'Deactive'){?> selected="selected"<?php }?> value="Deactive">Deactive</option>
				</select>
			</td>
		   </tr>
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
		    <td>&nbsp;</td>
			<td><input type="hidden" name="userid" value="<?= $row->userid  ?>" />
			<input type="submit" name="submit" value="Submit" />&nbsp;
			<input type="button" name="back" value="Back" onclick="history.go(-1);" /></td>
		   </tr>
		  </table>
		 </form>
		 <?php
		 endforeach;
		 ?>
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
