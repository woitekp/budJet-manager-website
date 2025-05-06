<?php
$incomesSum = end($incomesByCategories)['running_category_sum'] ?? 0;
$expensesSum = end($expensesByCategories)['running_category_sum'] ?? 0;
$totalSum = number_format((float)($incomesSum - $expensesSum), 2);

if ($totalSum > 0)
  $totalSumStyle = 'color-green';
elseif ($totalSum < 0)
  $totalSumStyle = 'color-red';
else
  $totalSumStyle = 'color-black';

?>
<div class="total-sum">
  <hr class="background-color-green">

  <p>Balance:</p>

  <p class=<?php echo $totalSumStyle; ?>>
    <?php echo $totalSum; ?>
  </p>

  <hr class="background-color-green">
</div>