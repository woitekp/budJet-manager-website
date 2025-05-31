<?php
$passwordError = escape($errors['password'][0] ?? '');
$confirmPasswordError = escape($errors['confirmPassword'][0] ?? '');
?>


<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" placeholder="New password" required="" class="form-control form-top-elem
        <?php if ($passwordError) : ?>
          form-error
        <?php endif; ?>
      "> <!-- end input -->

    <?php if ($passwordError) : ?>
      <div class="form-error-message">
        <?php echo $passwordError; ?>
      </div>
    <?php endif; ?>

    <label for="inputPassword" class="sr-only">Confirm password</label>
    <input name="confirmPassword" type="password" placeholder="Confirm password" requiredd="" class="form-control form-bottom-elem
        <?php if ($confirmPasswordError) : ?>
          form-error
        <?php endif; ?>
      "> <!-- end input -->

    <?php if ($confirmPasswordError) : ?>
      <div class="form-error-message">
        <?php echo $confirmPasswordError; ?>
      </div>
    <?php endif; ?>


    <button class="confirm btn btn-lg btn-primary btn-block" type="submit">Change password</button>
  </form>
</main>

<?php include $this->resolve("partials/_footer.php"); ?>