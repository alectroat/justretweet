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
	
	function sortByStatus(status)
	{
	var blog_id = document.getElementById('h_blog_id').value;
	window.location = "<?=base_url();?>admin/feed/"+blog_id+'/'+status+'/'+1;
	}
	
	function deleteFeed(blog_id,page,feed_id)
	{
		var con=confirm("Do You Really Want to Delete This!");
		if(con){
		var status = document.getElementById('s_status').value;
		window.location = '<?php echo site_url();?>admin/feed/delete/'+blog_id+'/'+status+'/'+page+'/'+feed_id;
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
	        var blog_id = document.getElementById('h_blog_id').value;
			var status = document.getElementById('s_status').value;
			window.location = "<?=base_url();?>admin/feed/"+blog_id+'/'+status+'/'+page;
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
                      <li><a href="<?php echo site_url();?>admin/user/" class="current"><span>Feed List</span></a></li>
           </ul>
        </div>
    </div>
<!-- TABS END -->    
</div>

<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <!--  TITLE START  --> 
    <div class="grid_9">
    <h1 class="dashboard">Feed List</h1>
    </div>
    <div class="clear">
    </div>
    <!--  TITLE END  -->    
    <!-- #PORTLETS START -->
    <div id="portlets">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed" style="height:30px">
		<div style="float:right">Sort By : 
		<select name="status_sort" id="status_sort" onchange="sortByStatus(this.value);">
		<option <?php if($status=='All'){?> selected="selected" <?php }?> value="All">All</option>
		<option <?php if($status=='Active'){?> selected="selected" <?php }?> value="Active">Active</option>
		<option <?php if($status=='Inactive'){?> selected="selected" <?php }?> value="Inactive">Inactive</option>
		</select></div></div>
		<div class="portlet-content nopadding">
        <form action="<?php echo site_url();?>admin/feed/multidelete/<?=$blog_id?>/<?=$status?>/<?=$current_page?>" method="post" onsubmit="return selectcheckbox();">
		<input type="hidden" name="total" id="total" value="<?= $feed_list->num_rows() ?>" />
		<input type="hidden" name="s_status" id="s_status" value="<?=$status?>" />
		<input type="hidden" name="h_blog_id" id="h_blog_id" value="<?=$blog_id?>" />
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
			<?php 
			if($feed_list->num_rows()>0) {
			?>            
			<thead>
              <tr>
                <th width="5px" scope="col"><input type="checkbox" name="allbox" id="allbox" value="0" onclick="checkAll(this.value)" /></th>
				<th width="30" scope="col">User</th>
				<th width="300" scope="col">Feeds</th>
				<th width="60" scope="col">&nbsp;</th>
				<th width="60" scope="col">&nbsp;</th>
                <th width="75" scope="col" style="text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
			<?php
			$i = 0;
			foreach($feed_list->result() as $list): 
			?>
              <tr>
			  <td colspan="6">
			  <div style="float:left;width:30px;margin-top:15px"> <input type="checkbox" name="checkbox[]" id="check<?= $i ?>" value="<?= $list->feed_id ?>" /></div>
			  <div style="float:left;width:85px"><img src="<?=$list->profile_image?>"/></div>
			  <div style="float:left;width:705px">
			  <div><div style="float:left;width:385px">&nbsp;</div>
				  <div style="float:left;width:150px">By : <?= rtrim($list->account,'000NA') ?></div>
				  <div style="float:left;width:170px">Posted on : <?php echo date("M jS Y", $list->timestamp); ?></div></div>
			  <div style="margin-top:25px;width:705px"><?=addAcronym($list->feed_title); ?></div>
			  </div>
			  <div style="float:left;width:70px;margin-top:15px">
			  <a href="<?php echo site_url();?>admin/feed/status/<?=$list->blog_id?>/<?=$status?>/<?=$current_page?>/<?=$list->feed_id?>" <?php if($list->status=='1'){ ?> class="active_icon"<?php }else{ ?> class="inactive_icon" <?php } ?> title="Change Status"></a>
			  <a href="#" class="delete_icon" onclick="deleteFeed('<?=$list->blog_id?>','<?=$current_page?>','<?=$list->feed_id?>')" title="Delete This"></a></div>
			  <div style="clear:both"></div>
			  </td>
			  </tr>
			  <?php
			  $i++;
			  endforeach;
			  ?>
       
			  <tr>
			  
			  <td colspan="8"><table><tr>
			  
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
			 <td colspan="8"><font style="color:#FF0000; font-weight:bold;"><center>You have no record yet!</center></font></td>
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
