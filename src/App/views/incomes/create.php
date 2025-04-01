<?php
$categories = $categories ?? array();
$currentDate = date("Y-m-d", time());
?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>

  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label for="inputAmount" class="sr-only">Amount</label>
    <input name="amount" type="number" min="0" step="0.01" class="form-control form-top-elem text-centered" placeholder="Amount" required="" autofocus="">

    <label for="inputDate" class="sr-only">Date</label>
    <input name="date" type="date" class="form-control form-middle-elem text-centered" value=<?php echo $currentDate ?> required="">

    <label for="inputCategory" class="sr-only">Category</label>
    <select name="category" type="text" class="form-control form-middle-elem text-centered" placeholder="Select category" required="">
      <option value="" selected>Select category</option>
      <?php
      foreach ($categories as $item) {
        echo "<option>" . $item . "</option>";
      }
      ?>
    </select>

    <label for="inputDescription" class="sr-only">Description</label>
    <input name="description" type="text" class="form-control form-bottom-elem text-centered" placeholder="Description (optional)">

    <div>
      <button name="add" class="confirm btn btn-lg btn-block" type="submit">Add income</button>
    </div>
  </form>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>