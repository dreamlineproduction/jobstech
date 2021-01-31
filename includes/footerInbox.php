<?php if(!isset($_COOKIE['close_cookie'])){ ?>
    <section class="clearfix cookies_footer row animated slideInLeft">
    <!-- <div class="col-md-2 d-flex align-items-center">
		<img src="<?= $site_url; ?>/images/cookie.svg" class="img-fluid" alt="">
	</div> -->
    <div class="col-md-12 text-center">
        <div class="float-right close btn btn-sm"><i class="fa fa-times"></i></div>
        <!-- <h4 class="mt-0 mt-lg-2 <?=($lang_dir == "right"?'text-right':'')?>"><?= $lang["cookie_box"]['title']; ?></h4> -->
        <p class="mb-1 ">

            Our site uses cookies: We use cookies to ensure you get the best experience. By using our website you agree
            to our <a href="terms_and_conditions" class="text-white"> Privacy Policy.</a>

            <!-- <?= $lang["cookie_box"]['title']; ?>:
            <?= str_replace('{link}',"$site_url/terms_and_conditions",$lang["cookie_box"]['desc']); ?> -->
            <a href="#" class="btn btn-primary btn-sm"> <?= $lang["cookie_box"]['button']; ?></a>

        </p>

    </div>
</section>
<?php } ?>

<section class="messagePopup animated slideInRight"></section>

<link rel="stylesheet" href="<?= $site_url; ?>/styles/msdropdown.css" />
<?php $disable_messages = 1; require("footerJs.php"); ?>