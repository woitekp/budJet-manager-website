<div class="table-container">
  <table>
    <caption>
      <?php echo $title ?>
    </caption>

    <tr class="column_names <?php echo $rowStyle ?>">
      <th>Category</th>
      <th>Amount</th>
    </tr>

    <?php
    foreach ($records as $record) {
      include $this->resolve("/balance/category.php");
    }
    ?>

    <?php
    $sum = end($records)['running_category_sum'] ?? 0; // last element running_category_sum
    $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
    ?>

    <tr class="<?php echo $rowStyle ?>">
      <th>SUM</th>
      <th><?php echo $sum ?></th>
    </tr>


  </table>
</div>