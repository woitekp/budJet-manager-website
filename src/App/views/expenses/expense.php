<?php
$id = escape($expense['id']);

$ordinalNumber = escape($expense['ordinal_number']);
$date = escape($expense['date']);
$amount = escape($expense['amount']);
$category = escape($expense['category']);
$payment = escape($expense['payment']);
$description = escape($expense['description']);

$expenseURI = '/expenses/' . $id;

$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="number width-ge-50"><?php echo $ordinalNumber ?></th>
  <th class="width-ge-120"><?php echo $date ?></th>
  <th class="width-ge-180"><?php echo $amount ?></th>
  <th class="width-ge-180"><?php echo $category ?></th>
  <th class="width-ge-120"><?php echo $payment ?></th>
  <th class="width-ge-350"><?php echo $description ?></th>
  <th class="null">
    <button class="confirm th-button btn width-ge-80" onclick=location.href="<?php echo $expenseURI ?>">
      Edit
    </button>
  </th>
  <th class="null">
    <form action=<?php echo $expenseURI ?> method="POST">
      <input type="hidden" name="_METHOD" value="DELETE" />

      <?php include $this->resolve("partials/_csrf.php") ?>

      <button class="cancel th-button btn width-ge-80" type="submit">
        Delete
      </button>
    </form>
  </th>
</tr>