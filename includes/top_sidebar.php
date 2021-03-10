<?php
  $online_sellers = array();
  $cat_id = array();
  $delivery_time = array();
  $seller_level = array();
  $seller_language = array();
  if(isset($_GET['online_sellers'])){
    foreach($_GET['online_sellers'] as $value){
      $online_sellers[$value] = $value;
    }
  }

  if(isset($_REQUEST['instant_delivery'])){
    $instant_delivery = $_REQUEST['instant_delivery'][0];
  }else{
    $instant_delivery = 0;
  }

  if(isset($_REQUEST['order'])){
    $order_by = $_REQUEST['order'][0];
  }else{
    $order_by = "DESC";
  }
  if(isset($_GET['seller_country'])){
    foreach($_GET['seller_country'] as $value){
      $sellerCountry[$value] = $value;
    }
  }
  if(isset($_GET['seller_city'])){
    foreach($_GET['seller_city'] as $value){
      $sellerCity[$value] = $value;
    }
  }


  if(isset($_GET['cat_id'])){
    foreach($_GET['cat_id'] as $value){
      $cat_id[$value] = $value;
    }
  }
  if(isset($_GET['delivery_time'])){
    foreach($_GET['delivery_time'] as $value){
      $delivery_time[$value] = $value;
    }
  }
  if(isset($_GET['seller_language'])){
    foreach($_GET['seller_language'] as $value){
      $seller_language[$value] = $value;
    }
  }
?>

<div class="row justify-content-center">
    <div class="online-seller mr-2 mb-2 mb-2 <?=($lang_dir == "right" ? 'text-right':'')?>">
        <a class="btn " href="#" role="button">
        <label>
                <input type="checkbox" value="1" class="get_online_sellers"
                    <?php if(isset($online_sellers["1"])){ echo "checked"; } ?>>
                <span><?= $lang['sidebar']['online_sellers']; ?></span>
            </label>
            </a>
    </div>


    <div class="online-seller mr-2 mb-2 mb-2 <?=($lang_dir == "right" ? 'text-right':'')?>">
        <a class="btn " href="#" role="button">
         <label>
        <input type="checkbox" value="1" class="get_instant_delivery" 
          <?php if($instant_delivery == 1){ echo "checked"; } ?> >
        <span><?= $lang['sidebar']['instant_delivery']; ?></span>
        </label>
        </a>
    </div>

    <div class="short-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang['sidebar']['sort_by']['title']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#"> <label
                class="checkcontainer"><?= $lang['sidebar']['sort_by']['new']; ?>
                <input type="radio" <?= ($order_by == "DESC")?"checked":""; ?> value="DESC" class="get_order"
                    name="radio">
                <span class="checkmark"></span>
            </label></a>
        <a class="dropdown-item" href="#"> <label
                class="checkcontainer"><?= $lang['sidebar']['sort_by']['old']; ?>
                <input type="radio" <?= ($order_by == "ASC")?"checked":""; ?> value="ASC" class="get_order"
                    name="radio">
                <span class="checkmark"></span>
            </label></a>

    </div>
</div>

</div>

<div class="country-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang["sidebar"]["seller_country"]; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?php
    $countries = [];
    if(isset($_SESSION['cat_id'])){
      $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
    }elseif(isset($_SESSION['cat_child_id'])){
      $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
    }
    while($row_proposals = $get_proposals->fetch()){
    $seller_id = $row_proposals->proposal_seller_id;
    $seller = $db->select("sellers",['seller_id'=>$seller_id])->fetch();
    $seller_country = $seller->seller_country;
    if(!empty($seller_country) AND @$countries[$seller_country] != $seller_country){
    $countries[$seller_country] = $seller_country;
    ?>



        <a class="dropdown-item" href="#"> <label>
        <label>
      <input type="checkbox" value="<?= $seller_country; ?>" class="get_seller_country"
      <?php if(isset($sellerCountry["$seller_country"])){ echo "checked"; } ?>>
      <span><?= $seller_country; ?></span>
      </label></a>

      <?php }} ?>


    </div>
</div>

</div>


<div class="city-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang["sidebar"]["seller_city"]; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <ul class="nav flex-column">
        <?php
    $cities = [];
    if(isset($_SESSION['cat_id'])){
      $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
    }elseif(isset($_SESSION['cat_child_id'])){
      $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
    }
    while($row_proposals = $get_proposals->fetch()){
    $seller_id = $row_proposals->proposal_seller_id;
    $seller = $db->select("sellers",['seller_id'=>$seller_id])->fetch();
    $seller_country = $seller->seller_country;
    $seller_city = $seller->seller_city;
    if(!empty($seller_city) AND @$cities[$seller_city] != $seller_city){
    $cities[$seller_city] = $seller_city;
    ?>
            <li class="nav-item checkbox checkbox-success" data-country="<?= $seller_country; ?>">
                <a class="dropdown-item" href="#">
                <label>
      <input type="checkbox" value="<?= $seller_city; ?>" class="get_seller_city"
      <?php if(isset($sellerCity["$seller_city"])){ echo "checked"; } ?>>
      <span><?= $seller_city; ?></span>
      </label>
                </a>
            </li>
            <?php }} ?>
        </ul>


    </div>
</div>

</div>




<div class="delivery-time-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang['sidebar']['delivery_time']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <ul class="nav flex-column">
        <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
        $delivery_id = $row_proposals->delivery_id;
        $select_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));
        $delivery_title = @$select_delivery_time->fetch()->delivery_title;
        if(!empty($delivery_title)){
      ?>
            <li class="nav-item checkbox checkbox-success">
                <a class="dropdown-item" href="#">
                <label>
        <input type="checkbox" value="<?= $delivery_id; ?>" class="get_delivery_time"
          <?php if(isset($delivery_time[$delivery_id])){ echo "checked"; } ?> >
        <span> <?= $delivery_title; ?> </span>
        </label>
                </a>
            </li>
            <?php }} ?>
        </ul>


    </div>
</div>

</div>



<div class="seller-level-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang['sidebar']['seller_level']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <ul class="nav flex-column">
        <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
          $level_id = $row_proposals->level_id;
          $select_seller_levels = $db->select("seller_levels",array('level_id' => $level_id));
          $level_title = @$db->select("seller_levels_meta",array("level_id"=>$level_id,"language_id"=>$siteLanguage))->fetch()->title;
          if(!empty($level_title)){
      ?>
            <li class="nav-item checkbox checkbox-success">
                <a class="dropdown-item" href="#">
                <label>
        <input type="checkbox" value="<?= $level_id; ?>" class="get_seller_level"
          <?php if(isset($seller_level[$level_id])){ echo "checked"; } ?> >
        <span> <?= $level_title; ?> </span>
        </label>
                </a>
            </li>
            <?php }} ?>
        </ul>


    </div>
</div>

</div>


<div class="seller-language-by-filter mr-2 mb-2  <?=($lang_dir == "right" ? 'text-right':'')?>">


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $lang['sidebar']['seller_lang']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <ul class="nav flex-column">
        <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
          $language_id = $row_proposals->language_id;
          $select_seller_languges = $db->select("seller_languages",array('language_id' => $language_id));
          $language_title = @$select_seller_languges->fetch()->language_title;
          if(!empty($language_title)){
      ?>
            <li class="nav-item checkbox checkbox-success">
                <a class="dropdown-item" href="#">
                <input type="checkbox" value="<?= $language_id; ?>" class="get_seller_language"
          <?php if(isset($seller_language[$language_id])){ echo "checked"; } ?> >
        <span> <?= $language_title; ?> </span>
        </label>
                </a>
            </li>
            <?php }} ?>
        </ul>


    </div>
</div>

</div>


<?php include("$dir/includes/comp/currency_converter.php"); ?>


    </div>




