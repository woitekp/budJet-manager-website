<?php
$id = escape($income['id']);

$ordinalNumber = escape($income['ordinal_number']);
$date = escape($income['date']);
$amount = escape($income['amount']);
$category = escape($income['category']);
$description = escape($income['description']);

$incomeURI = "/incomes/" . $id;

$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="number width-ge-50"><?php echo $ordinalNumber ?></th>
  <th class="width-ge-120"><?php echo $date ?></th>
  <th class="width-ge-180"><?php echo $amount ?></th>
  <th class="width-ge-180"><?php echo $category ?></th>
  <th class="width-ge-350"><?php echo $description ?></th>
  <th class="null">
    <button class="confirm th-button btn width-ge-80" onclick=location.href="<?php echo $incomeURI ?>">
      Edit
    </button>
  </th>
  <th class="null">
    <form action=<?php echo $incomeURI ?> method="POST">
      <input type="hidden" name="_METHOD" value="DELETE" />

      <?php include $this->resolve("partials/_csrf.php") ?>

      <button class="cancel th-button btn width-ge-80" type="submit">
        Delete
      </button>
    </form>
  </th>
</tr>