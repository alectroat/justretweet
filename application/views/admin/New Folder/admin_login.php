<?php
error_reporting(E_ALL - E_NOTICE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?></title>
<link href="<?=base_url();?>asset/css/960.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>asset/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>asset/css/text.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=base_url();?>asset/css/login.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript" type="text/javascript">
function login()
{
	document.form1.submit();
}
</script>
</head>

<body>
 <div class="container_16">
  <div class="grid_6 prefix_5 suffix_5">
   <h1><a href="#" target="_blank" style="color: #FFFFFF">iSnatch Admin - Login</a></h1>
    <div id="login">
     <!--<p class="tip">You just need to hit the button and you're in!</p>
     <p class="error">This is when something is wrong!</p>  --> 
	 <div style="color:#FF0000;"><?php echo $this->validation->error_string; ?></div>
	 <?php if($error){?>
	 <div style="color:#FF0000;"><?php echo $error; ?></div>
	 <?php } ?>      
      <form id="form1" name="form1" method="post" action="<?php echo site_url('admin/login'); ?>">
       <p>
    	<label><strong>Username</strong>
        <input type="text" name="username" class="inputText" id="username" />
    	</label>
  	   </p>
       <p>
    	<label><strong>Password</strong>
        <input type="password" name="password" class="inputText" id="password" />
  	    </label>
       </p>
		<input type="submit" name="submit" class="black_button" value="Login" id="submit" />
                 
      </form>
		  <br clear="all" />
    	</div>
        <div id="forgot">
        </div>
  </div>
 </div>
 <br clear="all" />
</body>
</html>
