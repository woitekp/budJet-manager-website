<?php
$incomes = $incomes ?? array();
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
      <th>Description</th>
    </tr>
    <?php
    $rowStyle = "row_dark";
    foreach ($incomes as $income) {
      echo
      '<tr class="' . $rowStyle . '">
        <th class="number">' . escape($income['ordinal_number']) . '</th>
        <th>' . escape($income['date']) . '</th>
        <th>' . escape($income['amount']) . '</th>
        <th>' . escape($income['category']) . '</th>
        <th>' . escape($income['description']) . '</th>
      </tr>';
      $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
    }
    ?>
  </table>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>