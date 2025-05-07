<table>
  <caption>
    <?php echo $title ?>
  </caption>

  <?php if ($records): ?>
    <tr class="column_names <?php echo $rowStyle ?>">
      <th>#</th>
      <th>Name</th>
    </tr>
  <?php else: ?>
    <tr class="column_names <?php echo $rowStyle ?>">
      <th class="null"></th>
      <th class="null"></th>
    </tr>
  <?php endif; ?>

  <?php
  foreach ($records as $record) {
    include $this->resolve("/settings/category.php");
  }
  include $this->resolve("/settings/create.php");
  ?>

</table>