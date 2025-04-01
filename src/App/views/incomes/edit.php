<?php
$categories = $categories ?? array();
$amount = escape($income['amount'] ?? '');
$date = escape($income['date'] ?? '');
$category = escape($income['category'] ?? '');
$description = escape($income['description'] ?? '');
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>

  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label for="inputAmount" class="sr-only">Amount</label>
    <input value="<?php echo $amount ?>" name="amount" type="number" min="0" step="0.01" class="form-control form-top-elem text-centered" placeholder="Amount" required="" autofocus="">

    <label for="inputDate" class="sr-only">Date</label>
    <input value="<?php echo $date ?>" name="date" type="date" class="form-control form-middle-elem text-centered" required="">

    <label for="inputCategory" class="sr-only">Category</label>
    <select name="category" type="text" class="form-control form-middle-elem text-centered" placeholder="Select category" required="">
      <option value="">Select category</option>
      <?php
      foreach ($categories as $item) {
        $selected = ($item == $category) ? 'selected=""' : '';
        echo "<option " . $selected . ">" . $item . "</option>";
      }
      ?>
    </select>

    <label for="inputDescription" class="sr-only">Description</label>
    <input value="<?php echo $description ?>" name="description" type="text" class="form-control form-bottom-elem text-centered" placeholder="Description (optional)">

    <div class="buttons-grid-container">
      <button name="cancel" class="cancel left btn btn-lg btn-primary btn-info" type="reset">Cancel</button>
      <button name="add" class="confirm right btn btn-lg btn-primary btn-info" type="submit">Edit income</button>
    </div>
  </form>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>