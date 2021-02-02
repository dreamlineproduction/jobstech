<?php
$search_query = @$_SESSION['search_query'];
$s_value = "%$search_query%";
$online_sellers = array();
$sellerCountry = array();
$seller_level = array();
$seller_language = array();

if(isset($_GET['online_sellers'])){
	foreach($_GET['online_sellers'] as $value){
		$online_sellers[$value] = $value;
	}
}
if(isset($_GET['seller_country'])){
	foreach($_GET['seller_country'] as $value){
		$sellerCountry[$value] = $value;
	}
}
if(isset($_GET['seller_level'])){
	foreach($_GET['seller_level'] as $value){
		$seller_level[$value] = $value;
	}
}
if(isset($_GET['seller_language'])){
	foreach($_GET['seller_language'] as $value){
		$seller_language[$value] = $value;
	}
}

?>
<div class="row justify-content-center">
<div class="online-seller-fr-page">
<label>
					<input type="checkbox" value="1" class="get_online_sellers" 
          <?php if(isset($online_sellers["1"])){ echo "checked"; } ?> >
					<span><?= $lang['sidebar']['online_sellers']; ?></span>
				</label>

</div>


<div class="seller-country-fr-page">



        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $lang["sidebar"]["seller_location"]; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#"> 
				<?php
    $sellers = $db->query("select DISTINCT seller_country from sellers");
		while($seller = $sellers->fetch()){
    $seller_country = $seller->seller_country;
    if (!empty($seller_country)){
    ?>
	
			<label>
			<input type="checkbox" value="<?= $seller_country; ?>" class="get_seller_country"
      <?php if(isset($sellerCountry["$seller_country"])){ echo "checked"; } ?>>
			<span><?= $seller_country; ?></span>
			</label>
		
    <?php }} ?>
				</a>
              

            </div>
        </div>


</div>


<div class="seller-level-fr-page">

<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $lang['sidebar']['seller_level']; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#"> 
			
      <?php
      $sellers = $db->query("select DISTINCT seller_level from sellers");
  		while($seller = $sellers->fetch()){
      $level_id = $seller->seller_level;
      $select_seller_levels = $db->select("seller_levels",array('level_id' => $level_id));
      $level_title = $db->select("seller_levels_meta",array("level_id"=>$level_id,"language_id"=>$siteLanguage))->fetch()->title;
      ?>
		
				<label>
				<input type="checkbox" value="<?= $level_id; ?>" class="get_seller_level"
        <?php if(isset($seller_level[$level_id])){ echo "checked"; } ?>>
				<span><?= $level_title; ?></span>
				</label>
			
      <?php } ?>
	
				</a>
              

            </div>
        </div>

</div>




<div class="seller-level-fr-page">

<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?= $lang['sidebar']['seller_lang']; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#"> 
			
				
			<?php
			$sellers = $db->query("select DISTINCT seller_language from sellers");
  		while($seller = $sellers->fetch()){
      $language_id = $seller->seller_language;
      if(!empty($language_id)){
			$select_seller_languges = $db->select("seller_languages",array('language_id' => $language_id));
			$language_title = @$select_seller_languges->fetch()->language_title;
			if (!empty($language_title)) {
			?>
			
				<label>
				<input type="checkbox" value="<?= $language_id; ?>" class="get_seller_language"
       	<?php if(isset($seller_language[$language_id])){ echo "checked"; } ?>>
				<span><?= $language_title; ?></span>
				</label>
		
      <?php }}} ?>
	
	
				</a>
              

            </div>
        </div>

</div>





</div>

