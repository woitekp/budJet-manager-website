<table>
  <caption>
    <?php echo $title ?>
  </caption>

  <tr class="column_names <?php echo $rowStyle ?>">
    <th>#</th>
    <th>Name</th>
  </tr>

  <?php
  foreach ($records as $record) {
    include $this->resolve("/settings/category.php");
  }
  ?>

</table>