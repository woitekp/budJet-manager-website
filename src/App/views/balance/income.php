<?php

$ordinalNumber = escape($income['ordinal_number']);
$date = escape($income['date']);
$amount = escape($income['amount']);
$category = escape($income['category']);
$description = escape($income['description']);

$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="number width-ge-50"><?php echo $ordinalNumber ?></th>
  <th class="width-ge-120"><?php echo $date ?></th>
  <th class="width-ge-180"><?php echo $amount ?></th>
  <th class="width-ge-180"><?php echo $category ?></th>
  <th class="width-ge-350"><?php echo $description ?></th>
</tr>