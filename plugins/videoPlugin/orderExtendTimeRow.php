<?php
$extendTime = $db->select("order_extend_time",array("order_id"=>$order_id));
while($extendTimeRow = $extendTime->fetch()){
	$id = $extendTimeRow->id;
	$extended_minutes = $extendTimeRow->extended_minutes;
	$price_per_minute = $extendTimeRow->price_per_minute;
	if($extendTimeRow->customAmount != 0){
		$amount = $extendTimeRow->customAmount;
	}else{
		$amount = $extendTimeRow->extended_minutes*$extendTimeRow->price_per_minute;
	}
	// $total += $amount;
?>
<tr>
	<td>Extend Time</td>
  <td><?= $extended_minutes; ?> Minutes</td>
  <td>
	  <?php if($extendTimeRow->customAmount != 0){ ?>
	  	
	  <?php }else{ ?>
	  	<?= $s_currency.$price_per_minute; ?>
	  <?php } ?>
  </td>
  <td><?= $s_currency.$amount; ?></td>
</tr>
<?php } ?>