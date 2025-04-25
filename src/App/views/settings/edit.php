<?php
$name = escape($name ?? '');
$error = escape($errors['name'][0] ?? '');
$edited = $edited ?? '';
echo $edited;

?>

<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>

  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label for="inputName" class="sr-only">Name</label>
    <input value="<?php echo $name ?>" name="name" type="text" class="form-control form-bottom-elem text-centered" placeholder="Name">

    <?php if ($error) : ?>
      <div class="form-error-message">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <div class="buttons-grid-container">
      <button name="cancel" class="cancel left btn btn-lg btn-primary btn-info" type="reset">Cancel</button>
      <button name="add" class="confirm right btn btn-lg btn-primary btn-info" type="submit">Edit category</button>
    </div>


  </form>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>