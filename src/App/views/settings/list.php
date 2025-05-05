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
  <div>
    <?php if ($error) : ?>
      <div class="form-error-message">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>
  </div>

  <div>
    <?php
    $rowStyle = 'row_light';
    $title = 'Incomes categories';
    $records = $incomesCategories;
    $editPath = $mainPath . 'incomes/';
    $inputName = "incomeCategory";
    include $this->resolve("settings/categories.php");
    ?>
  </div>

  <div>
    <?php
    $rowStyle = 'row_light';
    $title = 'Expense categories';
    $records = $expenseCategories;
    $editPath = $mainPath . 'expenses/';
    $inputName = "expenseCategory";
    include $this->resolve("settings/categories.php");
    ?>
  </div>

  <div>
    <?php
    $rowStyle = 'row_light';
    $title = 'Payment methods';
    $records = $paymentMethods;
    $editPath = $mainPath . 'payments/';
    $inputName = "paymentMethod";
    include $this->resolve("settings/categories.php");
    ?>
  </div>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>