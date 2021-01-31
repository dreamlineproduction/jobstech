<div class="card">
<div class="card-body">
<!-- <div class="col-md-2">

		<?php if(!empty($seller_image)){ ?>
		<img src="<?= $seller_image; ?>" class="img-fluid rounded-circle mb-3" style="height: 27px;">
		<?php }else{ ?>
		<img src="<?= $site_url; ?>/user_images/empty-image.png"  class="img-fluid rounded-circle mb-3" style="height: 27px;">
		<?php } ?>
		
		<span><?= $lang['welcome']; ?> <?= ucfirst($login_user_name); ?></span>
		
</div> -->
<div class="row text-center user-home-topbar-style-col">
<div class="col-md-2">
<h5><a href="<?= $site_url; ?>/dashboard"><?= $lang['menu']['dashboard']; ?></a></h5>
</div>
<div class="col-md-2">
<h5><a href="<?= $site_url; ?>/proposals/create_proposal"><?= $lang['user_home']['add_proposal']; ?></a></h5>
</div>
<div class="col-md-2">
<h5 class="mb-0"><a href="<?= $site_url; ?>/requests/post_request"><?= $lang['menu']['post_request']; ?></a></h5>
</div>
<div class="col-md-2">
<?php if(isset($count_active_proposals) AND @$count_active_proposals  > 0){ ?>
				<h5><a href="<?= $site_url; ?>/selling_orders"><?= $lang['user_home']['view_sales']; ?></a></h5>
				<?php }else{ ?>
				<h5><a href="<?= $site_url; ?>/buying_orders"><?= $lang['user_home']['view_purchases']; ?></a></h5>
				<?php } ?>
				<h5>
</div>

<div class="col-md-2">
<h5>
               <a href="<?= $site_url; ?>/settings?profile_settings">
                  <?= $lang['user_home']['edit_profile']; ?>
               </a>
            </h5>
</div>

<div class="col-md-2">
<h5 class="mb-0"><a href="<?= $site_url; ?>/settings"><?= $lang['menu']['settings']; ?></a></h5>
</div>



</div>
</div>
</div>




<!-- <div class="card rounded-0 mb-3 welcome-box">
	<div class="card-body pb-2">
	
		<?php if(!empty($seller_image)){ ?>
		<img src="<?= $seller_image; ?>" class="img-fluid rounded-circle mb-3">
		<?php }else{ ?>
		<img src="<?= $site_url; ?>/user_images/empty-image.png"  class="img-fluid rounded-circle mb-3">
		<?php } ?>
		</center>
		<h5><?= $lang['welcome']; ?>, <span class="text-success"><?= ucfirst($login_user_name); ?></span> </h5>
		<hr> -
		<div class="row m-0">
			<div class="col-lg-6 m-0 p-0 pr-2 pb-lg-0 pr-lg-2 pb-md-2 pr-sm-2">
				<h5><a href="<?= $site_url; ?>/dashboard"><?= $lang['menu']['dashboard']; ?></a></h5>
				<h5><a href="<?= $site_url; ?>/proposals/create_proposal"><?= $lang['user_home']['add_proposal']; ?></a></h5>
				<h5 class="mb-0"><a href="<?= $site_url; ?>/requests/post_request"><?= $lang['menu']['post_request']; ?></a></h5>
			</div>
			<div class="col-lg-6 m-0 p-0 pl-2 pt-lg-0 pl-lg-2 pl-md-0 pt-md-2 pl-sm-2">
				<?php if(isset($count_active_proposals) AND @$count_active_proposals  > 0){ ?>
				<h5><a href="<?= $site_url; ?>/selling_orders"><?= $lang['user_home']['view_sales']; ?></a></h5>
				<?php }else{ ?>
				<h5><a href="<?= $site_url; ?>/buying_orders"><?= $lang['user_home']['view_purchases']; ?></a></h5>
				<?php } ?>
				<h5>
			<a href="<?= $site_url; ?>/settings?profile_settings">
				<?= $lang['user_home']['edit_profile']; ?>
			</a>
			</h5>
				<h5 class="mb-0"><a href="<?= $site_url; ?>/settings"><?= $lang['menu']['settings']; ?></a></h5>
			</div>
		</div>
		<hr>
		<h5>
		<a href="<?= $site_url; ?>/customer_support">
			<?= $lang["user_home"]['contact']; ?> <?= $site_name; ?>   
		</a>
	</h5>
	</div>
</div>  -->




<script>
$(document).ready(function(){
	// Sticky Code start //
	if($(window).width() < 767){
		// 
	}else{
		$(".sticky-start").sticky({
			topSpacing:20,
			zIndex:500,
			bottomSpacing:400,
		});
	}
	// Sticky code ends //
});
</script>