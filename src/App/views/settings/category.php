<?php
$id = escape($record['id']);
$name = escape($record['name']);

$ordinalNumber = escape($record['ordinal_number']);
$name = escape($record['name']);
$categoryURI = $editPath . $id;
$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="number width-ge-50"><?php echo $ordinalNumber ?></th>
  <th class="width-ge-180"><?php echo $name ?></th>
  <th class="null">
    <button class="confirm th-button btn width-ge-80" onclick=location.href="<?php echo $categoryURI ?>">
      Edit
    </button>
  </th>
  <th class="null">
    <form action=<?php echo $categoryURI ?> method="POST">
      <input type="hidden" name="_METHOD" value="DELETE" />

      <?php include $this->resolve("partials/_csrf.php") ?>

      <button class="cancel th-button btn width-ge-80" type="submit">
        Delete
      </button>
    </form>
  </th>
</tr>