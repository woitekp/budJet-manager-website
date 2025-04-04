<?php

$ordinalNumber = escape($expense['ordinal_number']);
$date = escape($expense['date']);
$amount = escape($expense['amount']);
$category = escape($expense['category']);
$payment = escape($expense['payment']);
$description = escape($expense['description']);

$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="number width-ge-50"><?php echo $ordinalNumber ?></th>
  <th class="width-ge-120"><?php echo $date ?></th>
  <th class="width-ge-180"><?php echo $amount ?></th>
  <th class="width-ge-180"><?php echo $category ?></th>
  <th class="width-ge-120"><?php echo $payment ?></th>
  <th class="width-ge-350"><?php echo $description ?></th>
</tr>