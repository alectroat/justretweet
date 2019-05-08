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
	function deletePackage(id,cp)
	{
		var con=confirm("Do You Really Want to Delete This!");
		if(con){
		window.location = '<?php echo site_url();?>admin/package/delete/'+id+'/'+cp;
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
                      <li><a href="<?=site_url('admin/package')?>" class="current"><span>Package List</span></a></li>
					  <li><a href="<?=site_url('admin/payment')?>"><span>Payment Histories</span></a></li>
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
        <div class="portlet-header fixed"> <input type="button" name="back" value="Back" onclick="history.go(-1);" />&nbsp;<font style="padding-left:750px;"><a href="<?=site_url()?>admin/package/add">Add Package</a></font></div>
		<div class="portlet-content nopadding">
        <form action="<?php echo site_url();?>admin/package/multidelete/<?= $current_page ?>" method="post" onsubmit="return selectcheckbox();">
		<input type="hidden" name="total" id="total" value="<?=$package_list->num_rows()?>" />
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
			<?php 
			if($package_list->num_rows()>0) {
			?>            
			<thead>
              <tr>
                <th width="24" scope="col"><input type="checkbox" name="allbox" id="allbox" value="0" onclick="checkAll(this.value)" /></th>
				<th width="160" scope="col">Package Name</th>
				<th width="150" scope="col">Package Type</th>
				<th width="100" scope="col">Points</th>
                <th width="100" scope="col">Package Duration</th>
				<th width="103" scope="col">Package Value</th>
                <th width="90" scope="col" style="text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
			<?php
			$i = 0;
			foreach($package_list->result() as $row): 
			?>
              <tr>
                <td width="24"><label>
                    <input type="checkbox" name="checkbox[]" id="check<?= $i ?>" value="<?= $row->package_id ?>" />
                </label></td>
				<td><?= $row->package_name ?></td>
				<td><?= $row->package_type ?></td>
				<td><?= $row->bonus_points ?></td>
				<td><?=$row->package_duration.' '.$row->package_duration1?></td>
				<td><?=$row->package_value?></td>
                <td width="125" style="text-align:center;">
					<a href="<?php echo site_url();?>admin/package/edit/<?= $row->package_id ?>/<?= $current_page ?>" class="edit_icon" title="Edit This"></a>
					<a href="#" class="delete_icon" onclick="deletePackage('<?= $row->package_id ?>','<?= $current_page ?>')" title="Delete This"></a>					
				</td>
              </tr>
              <?php
			  $i++;
			  endforeach;
			  ?>

			  <tr>
			  
			  <td colspan="7"><table><tr>
			  
				 <td style=" border:none;"><input type="submit" id="submit" name="submit" value="Delete"  /></td>
				 <td style="border:none; width:300px;">
				  Results <? echo $start+1;?> -<? echo $end_result;?> of <? echo $total_results;?>
				 </td>
				 <td style="text-align:right; padding-right: 20px; border:none;"> Page 
				 <? if(($current_page-1) > 0 && ($current_page-1) <= $total_page ){?><a href="#" onclick="doSearch('<? echo $current_page-1; ?>')">Previous</a> <? } ?>
				 <? if(($current_page-2) > 0 && ($current_page-2) <= $total_page ){?><a href="#" onclick="doSearch('<? echo $current_page-2; ?>')"><? echo $current_page-2; ?></a><? } ?>
				 <? if(($current_page-1) > 0 && ($current_page-1) <= $total_page ){?><a href="#" onclick="doSearch('<? echo $current_page-1; ?>')"><? echo $current_page-1; ?></a><? } ?>
				 <? if(($current_page) > 0 && ($current_page) <= $total_page ){?><? echo $current_page; ?><? } ?>
				 <? if(($current_page+1) > 0 && ($current_page+1) <= $total_page ){?><a href="#" onclick="doSearch('<? echo $current_page+1; ?>')"><? echo $current_page+1; ?></a><? } ?>
				 <? if(($current_page+2) > 0 && ($current_page+2) <= $total_page ) {?><a href="#" onclick="doSearch('<? echo $current_page+2; ?>')"><? echo $current_page+2; ?></a><? } ?>
				 <? if(($current_page+1) > 0 && ($current_page+1) <= $total_page ){?><a href="#" onclick="doSearch('<? echo $current_page+1; ?>')">Next</a><? } ?>
				 </td> 
				 
				 </tr></table></td>
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
Website Administration Share by <a href="#">iSnatch</a></div>
<!-- FOOTER END -->
</body>
</html>
