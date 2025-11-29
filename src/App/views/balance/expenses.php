<div class="table-container">
  <table>
    <caption>
      <?php echo $title ?>
    </caption>

    <tr class="column_names <?php echo $rowStyle ?>">
      <th>#</th>
      <th>Date</th>
      <th>Amount</th>
      <th>Category</th>
      <th>Payment</th>
      <th>Description</th>
    </tr>
    <?php
    foreach ($expenses as $expense) {
      include $this->resolve("balance/expense.php");
    }
    ?>

  </table>
</div>