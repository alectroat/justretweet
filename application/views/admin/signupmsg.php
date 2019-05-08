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
	<script language="javascript" type="text/javascript">
	function deletePayAcc(id)
	{	//alert(id);
		var con=confirm("Do You Really Want to Delete This!");
		if(con){
		window.location = '<?php echo site_url();?>admin/setting/delete/'+id;
		}
	}
	function changeAccountStatus(id,st,cp,uid)
	{
		var con = confirm("Do You Really Want to Change This Status");
		if(con){
			window.location = '<?=site_url()?>admin/user/changeAccountStatus/'+id+'/'+st+'/'+cp+'/'+uid;
		}
	}
	
	function checkAll(a)
	{
		var total = document.getElementById('total').value;
		if(a == 0)
		{
			for(q=0;q<total;q++)
			{
				document.getElementById('check'+q).checked = true;
			}
			document.getElementById('allbox').value = 1;
		}
		if(a == 1)
		{
			for(q=0;q<total;q++)
			{
				document.getElementById('check'+q).checked = false;
			}
			document.getElementById('allbox').value = 0;
		}
		
	}
	
	function selectcheckbox()
	{
	 var total = document.getElementById('total').value;
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if(document.getElementById('check'+i).checked == true){
		j = 1;
		break;
		}
	 }
	 if(!j)
	 {
		alert("Please select rows you want to process!");
		return false;
	 }
	}
	
	function doSearch(page){
			window.location = "<?=base_url();?>admin/package/index/"+page;
		}
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
                      <li><a href="<?=site_url('admin/setting')?>"><span>Account Setting</span></a></li>
					  <li><a href="<?=site_url('admin/setting/signupmessage')?>" class="current"><span>Sign Up Message</span></a></li>
					  <li><a href="<?=site_url('admin/user')?>"><span>Users Setting</span></a></li>
					  <li><a href="<?=site_url('admin/banner')?>"><span>Bannar Setting</span></a></li>
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Package List</h1>
    </div>
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed"> <input type="button" name="back" value="Back" onclick="history.go(-1);" />
          &nbsp;<font style="padding-left:725px;"><a href="<?=site_url()?>admin/setting/addsignmsg">Add SignUp Message </a></font></div>
		<div class="portlet-content nopadding">
        <form action="<?php echo site_url();?>admin/package/multidelete/<?= $current_page ?>" method="post" onsubmit="return selectcheckbox();">
		<input type="hidden" name="total" id="total" value="<?=$signup_msg->num_rows()?>" />
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
			<?php 
			if($signup_msg->num_rows()>0) {
			?>            
			<thead>
              <tr>
                <th width="24" scope="col"><input type="checkbox" name="allbox" id="allbox" value="0" onclick="checkAll(this.value)" /></th>
				<th width="160" scope="col">SignUp Message</th>
						
                <th width="90" scope="col" style="text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
			<?php
			$msg = $signup_msg->result();
			?>
              <tr>
                <td width="24"><label>
                    <input type="checkbox" name="checkbox[]" id="check<?= 0 ?>" value="<?= $row->package_id ?>" />
                </label></td>
				<td><?= $msg[0]->signup_message ?></td>
							
                <td width="125" style="text-align:center;">
					<a href="<?php echo site_url();?>admin/setting/editmsg/<?=$msg[0]->signmsg_id ?>" class="edit_icon" title="Edit This"></a>
					<a href="#" class="delete_icon" onclick="deletemsg('<?= $msg[0]->signmsg_id ?>')" title="Delete This"></a>					
				</td>
              </tr>
            

			
            </tbody>
			<?php
			}else{
			?>
			<tr>
			 <td colspan="7"><font style="color:#FF0000; font-weight:bold;"><center>You have no record yet!</center></font></td>
			</tr>
			<?php
			}
			?>
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
		<div class='hidden'>
			<div id="inline_example1" title="This is a modal box" style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
            			
			<p><strong>Try testing yourself!</strong></p>
            <p>You can call as many dialogs you want with jQuery UI.</p>
			</div>
		</div>
</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<div class="container_16" id="footer">
Website Administration Share by <a href="#">Retweet</a></div>
<!-- FOOTER END -->
</body>
</html>
