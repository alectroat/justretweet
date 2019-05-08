<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first" id="one"><a href="<?=site_url()?>admin/admin/" <?php if($menu=='admin_profile'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner dashboard">Dashboard</span></span></a></li>
		<li class="item middle" id="five"><a href="<?php echo site_url();?>admin/user/" <?php if($menu=='view_user'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner users">Users</span></span></a></li>
	
		
		<li class="item middle"><a href="<?=site_url()?>admin/retweet" <?php if($menu=='retweet'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner retweet">Retweet</span></span></a></li>
        <!--<li class="item middle"><a href="<?=site_url()?>admin/youtube" <?php if($menu=='youtube'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner youtube">YouTube</span></span></a></li>
		<li class="item middle"><a href="<?=site_url()?>admin/website" <?php if($menu=='website'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner website">Website</span></span></a></li>
		<li class="item middle"><a href="<?=site_url()?>admin/blog" <?php if($menu=='blog'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner blog">Blog</span></span></a></li> -->
		<li class="item middle"><a href="<?=site_url()?>admin/banner" <?php if($menu=='banner'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner banner">Banner</span></span></a></li>     
		
		<li class="item middle" id="ten"><a href="<?=site_url()?>admin/package" <?php if($menu=='package'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner package">Package</span></span></a></li>        
		<li class="item last" id="ten"><a href="<?=site_url()?>admin/setting" <?php if($menu=='setting'){?> class="main current"<?php }else{?>class="main"<?php }?>><span class="outer"><span class="inner settings">setting</span></span></a></li>
	</ul>
</div>