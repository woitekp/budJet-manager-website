<?php
$rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
$inputName = escape($inputName);
?>

<tr class="<?php echo $rowStyle ?>">
  <th class="null width-ge-50"></th>
  <form method="post">
    <th class="null width-ge-180">
      <label for=<?php echo $inputName ?> class="sr-only">Category</label>
      <input name=<?php echo $inputName ?> type="text" min="0" step="0.01" class="form-control text-centered" placeholder="Category">
    </th>
    <th class="null">

      <?php include $this->resolve("partials/_csrf.php") ?>

      <button name="category" class="confirm th-button btn width-ge-80" type="submit">
        Add
      </button>
    </th>
  </form>
</tr>