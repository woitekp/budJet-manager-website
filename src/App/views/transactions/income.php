<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>

  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label for="inputAmount" class="sr-only">Amount</label>
    <input name="amount" type="number" min="0" step="0.01" class="form-control form-top-elem text-centered" placeholder="Amount" required="" autofocus="">

    <label for="inputDate" class="sr-only">Date</label>
    <input name="date" type="date" class="form-control form-middle-elem text-centered" value=<?php echo date("Y-m-d", time()) ?> required="">

    <!-- <label for="inputCategory" class="sr-only">Category</label>
    <select name="category" type="text" class="form-control form-middle-elem text-centered" placeholder="Select category" required="">
      <option value="" selected>Select category</option>

    </select> -->

    <label for="inputComment" class="sr-only">Comment</label>
    <input name="comment" type="text" class="form-control form-bottom-elem text-centered" placeholder="Comment (optional)" autofocus="">

    <div class="grid-container">
      <button name="cancel" class="cancel left btn btn-lg btn-primary btn-info" type="submit">Cancel</button>
      <button name="add" class="confirm right btn btn-lg btn-primary btn-info" type="submit">Add income</button>
    </div>
  </form>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>