<?php if($enable_converter == 1){ ?>
<div class="online-seller mr-2 mb-2 mb-2 <?=($lang_dir == "right" ? 'text-right':'')?>">
<div class="dropdown">
<select id="currencySelect" class="form-control">
      <option data-url="<?= "$site_url/change_currency?id=0"; ?>">
        <?= "$s_currency_name ($s_currency)"; ?>
      </option>
      <?php
      $get_currencies = $db->select("site_currencies");
      while($row = $get_currencies->fetch()){
      $id = $row->id;
      $currency_id = $row->currency_id;
      $position = $row->position;

      $get_currency = $db->select("currencies",array("id" =>$currency_id));
      $row_currency = $get_currency->fetch();
      $name = $row_currency->name;
      $symbol = $row_currency->symbol;
      ?>
      <option data-url="<?= "$site_url/change_currency?id=$id"; ?>" <?php if($id == @$_SESSION["siteCurrency"]){ echo "selected"; } ?>>
        <?= $name; ?> (<?= $symbol ?>)
      </option>
      <?php } ?>
    </select>
</div>
    </div>

<?php } ?>