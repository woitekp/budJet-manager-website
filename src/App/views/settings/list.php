<?php
$mainPath = '/settings/';
$incomesCategories = $incomesCategories ?? array();
$expenseCategories = $expenseCategories ?? array();
$paymentMethods = $paymentMethods ?? array();

$error = escape($errors['name'][0] ?? '');
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <?php if ($error) : ?>
    <div class="form-error-message">
      <?php echo $error; ?>
    </div>
  <?php endif; ?>


  <?php
  $rowStyle = 'row_light';
  $title = 'Incomes categories';
  $records = $incomesCategories;
  $editPath = $mainPath . 'incomes/';
  include $this->resolve("settings/categories.php");
  ?>

  <?php
  $rowStyle = 'row_light';
  $title = 'Expense categories';
  $records = $expenseCategories;
  $editPath = $mainPath . 'expenses/';
  include $this->resolve("settings/categories.php");
  ?>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>