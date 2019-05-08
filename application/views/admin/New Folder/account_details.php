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
<script type="text/javascript">
function deleteUser(id,cp)
	{
		var con=confirm("Do You Really Want to Delete This!");
		if(con){
		window.location = '<?php echo site_url();?>admin/user/delete/'+id+'/'+cp;
		}
	}
</script> 
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	
<!-- HIDDEN COLOR CHANGER -->      

  	<!--LOGO-->
	<div class="grid_8" id="logo">iSnatch Administration</div>
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
                      <li><a href="#" class="current"><span>Account Details</span></a></li>
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Account Details</h1>
    </div>
	
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed"> <input type="button" name="back" value="Back" onclick="history.go(-1);" />&nbsp;</div>
		<div class="portlet-content nopadding">
		<?php
		foreach($account_info->result() as $row):
		?> 
		  <table border="0" width="100%" align="center"> 
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   
		    <tr>
		    <td style="padding-left:40px; width:110px;">Profile Picture&nbsp;</td>
			<td><img width="40" height="40" src="<?=$row->profile_image?>" /></td>
		   </tr>
		   
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   
		    <tr>
		    <td style="padding-left:40px; width:110px;">Account&nbsp;</td>
			<td><?= $row->account ?></td>
		   </tr>
		   
		    
		    <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   
		   <tr>
		    <td style="padding-left:40px; width:110px;">Status&nbsp;</td>
			<td><?= $row->status ?></td>
		   </tr>
		   
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		   
		   <tr>
		    <td style="padding-left:40px; width:110px;">Entry Date&nbsp;</td>
			<td><?= date("jS M Y",strtotime($row->entry_date)) ?></td>
		   </tr>
		   
		   <tr>
		    <td colspan="2">&nbsp;</td>
		   </tr>
		  </table>
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
Website Administration Share by <a href="#">iSnatch</a></div>
<!-- FOOTER END -->
</body>
</html>
