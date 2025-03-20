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
        <th class="number width-ge-50">' . escape($income['ordinal_number']) . '</th>
        <th class="width-ge-120">' . escape($income['date']) . '</th>
        <th class="width-ge-180">' . escape($income['amount']) . '</th>
        <th class="width-ge-180">' . escape($income['category']) . '</th>
        <th class="width-ge-350">' . escape($income['description']) . '</th>
      </tr>';
      $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
    }
    ?>
  </table>

  <div class="pagination">
    <a
      <?php if ($currentPage > 1) : ?> href="/incomes?<?php echo escape($previousPageQuery); ?>"
      <?php endif; ?>>
      &lt&lt
    </a>

    <?php foreach ($pageLinks as $pageNum => $query) : ?>
      <a href="/incomes?<?php echo escape($query); ?>" class=<?php echo $pageNum + 1 === $currentPage ? "current_page" : "" ?>>
        <?php echo $pageNum + 1; ?>
      </a>
    <?php endforeach; ?>

    <a
      <?php if ($currentPage < $lastPage) : ?> href=" /incomes?<?php echo escape($nextPageQuery); ?>"
      <?php endif; ?>>
      &gt&gt
    </a>
  </div>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>