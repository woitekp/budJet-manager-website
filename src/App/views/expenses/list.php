<?php
$expenses = $expenses ?? array();

$previousPageQuery = escape($previousPageQuery);
$previousPageHref = ($currentPage > 1) ? "href='/expenses?{$previousPageQuery}'" : '';

$nextPageQuery = escape($nextPageQuery);
$nextPageHref = ($currentPage < $lastPage) ? "href='/expenses?{$nextPageQuery}'" : '';

$rowStyle = 'row_light'
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <?php include $this->resolve("partials/_search.php"); ?>
  <table>
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
      include $this->resolve("expenses/expense.php");
    }
    ?>
  </table>

  <div class="pagination">
    <a <?php echo $previousPageHref; ?>>
      &lt&lt
    </a>

    <?php foreach ($pageLinks as $pageNum => $query) : ?>
      <a href="/expenses?<?php echo escape($query); ?>" class=<?php echo $pageNum + 1 === $currentPage ? "current_page" : "" ?>>
        <?php echo $pageNum + 1; ?>
      </a>
    <?php endforeach; ?>

    <a <?php echo $nextPageHref; ?>>
      &gt&gt
    </a>
  </div>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>