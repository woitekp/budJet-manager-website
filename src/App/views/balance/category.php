<?php
$category = escape($record['category']);
$categorySum = escape($record['category_sum']);
$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th><?php echo $category ?></th>
  <th><?php echo $categorySum ?></th>
</tr>