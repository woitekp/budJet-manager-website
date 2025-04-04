<table>
  <caption>
    <?php echo $title ?>
  </caption>

  <tr class="column_names <?php echo $rowStyle ?>">
    <th>#</th>
    <th>Date</th>
    <th>Amount</th>
    <th>Category</th>
    <th>Description</th>
  </tr>
  <?php
  foreach ($incomes as $income) {
    include $this->resolve("balance/income.php");
  }
  ?>

</table>