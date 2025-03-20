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
        <th class="number width-ge-50">' . escape($expense['ordinal_number']) . '</th>
        <th class="width-ge-120">' .  escape($expense['date']) . '</th>
        <th class="width-ge-180">' .  escape($expense['amount']) . '</th>
        <th class="width-ge-180">' .  escape($expense['category']) . '</th>
        <th class="width-ge-120">' .  escape($expense['payment']) . '</th>
        <th class="width-ge-350">' .  escape($expense['description']) . '</th>
      </tr>';
      $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
    }
    ?>
  </table>

  <div class="pagination">
    <a
      <?php if ($currentPage > 1) : ?> href="/expenses?<?php echo escape($previousPageQuery); ?>"
      <?php endif; ?>>
      &lt&lt
    </a>

    <?php foreach ($pageLinks as $pageNum => $query) : ?>
      <a href="/expenses?<?php echo escape($query); ?>" class=<?php echo $pageNum + 1 === $currentPage ? "current_page" : "" ?>>
        <?php echo $pageNum + 1; ?>
      </a>
    <?php endforeach; ?>

    <a
      <?php if ($currentPage < $lastPage) : ?> href=" /expenses?<?php echo escape($nextPageQuery); ?>"
      <?php endif; ?>>
      &gt&gt
    </a>
  </div>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>