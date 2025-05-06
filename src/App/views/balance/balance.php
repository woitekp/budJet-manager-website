<?php
// balance period possible values
$currentMoth = 'Current month';
$previousMonth = 'Previous month';
$currentYear = 'Current year';
$custom = 'Custom';

$balancePeriod = escape($balancePeriod ?? 'currentMonth');
$startDate = escape($startDate ?? '');
$endDate = escape($endDate ?? '');
$error = escape($error ?? '');

$incomesByCategories = $incomesByCategories ?? array();
$expensesByCategories = $expensesByCategories ?? array();
$incomes = $incomes ?? array();
$expenses = $expenses ?? array();
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>

  <form class="form" method="GET">
    <label for="inputPeriod" class="sr-only">Period</label>
    <select name="balancePeriod" type="text" id="selectPeriod" class="form-control form-bottom-elem text-centered" placeholder="Select Period" required="">
      <option
        <?php if ($balancePeriod == $currentMoth) echo 'selected'; ?>>
        <?php echo $currentMoth ?>
      </option>
      <option
        <?php if ($balancePeriod == $previousMonth) echo 'selected'; ?>>
        <?php echo $previousMonth ?>
      </option>
      <option
        <?php if ($balancePeriod == $currentYear) echo 'selected'; ?>>
        <?php echo $currentYear ?>
      </option>
      <option
        <?php if ($balancePeriod == $custom) echo 'selected'; ?>>
        <?php echo $custom ?>
      </option>
    </select>

    <!-- TODO with JS: hide date inputs if not custom option selected -->
    <label class="input-description">Date range for custom period:</label>
    <input name="startDate" type="date" class="form-control form-middle-elem text-centered"
      value=<?php echo $startDate; ?>>
    <input name="endDate" type="date" class="form-control form-bottom-elem text-centered"
      value=<?php echo $endDate; ?>>

    <?php if ($error) : ?>
      <div class="form-error-message">
        <?php echo $error ?>
      </div>
    <?php endif ?>

    <div>
      <button name="submit" class="confirm btn btn-lg" type="submit">Submit</button>
    </div>
  </form>

  <?php
  include $this->resolve("balance/total.php");
  ?>


  <?php
  $rowStyle = 'row_light';
  $title = 'Incomes';
  $records = $incomesByCategories;
  include $this->resolve("balance/categories.php");
  ?>

  <?php
  $rowStyle = 'row_light';
  $title = 'Expenses';
  $records = $expensesByCategories;
  include $this->resolve("balance/categories.php");
  ?>

  <?php
  if ($records)
    include $this->resolve("balance/chart.php")
  ?>

  <?php
  $rowStyle = 'row_light';
  $title = 'Incomes details';
  include $this->resolve("balance/incomes.php");
  ?>

  <?php
  $rowStyle = 'row_light';
  $title = 'Expenses details';
  include $this->resolve("balance/expenses.php");
  ?>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>