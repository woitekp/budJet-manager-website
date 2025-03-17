<?php
$expenses = $expenses ?? array();
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <?php include $this->resolve("partials/_search.php"); ?>
  <table>
    <tr class="column_names row_light">
      <th>#</th>
      <th>Date</th>
      <th>Amount</th>
      <th>Category</th>
      <th>Payment</th>
      <th>Description</th>
    </tr>
    <?php
    $rowStyle = "row_dark";
    foreach ($expenses as $expense) {
      echo
      '<tr class="' . $rowStyle . '">
        <th class="number">' . escape($expense['ordinal_number']) . '</th>
        <th>' . escape($expense['date']) . '</th>
        <th>' .  escape($expense['amount']) . '</th>
        <th>' .  escape($expense['category']) . '</th>
        <th>' .  escape($expense['payment']) . '</th>
        <th>' .  escape($expense['description']) . '</th>
      </tr>';
      $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
    }
    ?>
  </table>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>