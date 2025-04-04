<?php
$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th><?php echo $record['category'] ?></th>
  <th><?php echo $record['category_sum'] ?></th>
</tr>