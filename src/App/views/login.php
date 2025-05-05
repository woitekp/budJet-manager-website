<?php
$emailError = escape($errors['email'][0] ?? '');
$passwordError = escape($errors['password'][0] ?? '');

$email = escape($providedFormData['email'] ?? '');
?>


<?php include $this->resolve("partials/_header.php"); ?>

<main>

  <form class="form" method="post">

    <?php include $this->resolve("partials/_csrf.php"); ?>

    <h2 class="h3 mb-3 font-weight-normal">Please sign in</h2>

    <label for="inputEmail" class="sr-only">Email address</label>
    <input value="<?php echo $email; ?>" name="email" type="email" placeholder="Email address" required="" autofocus="" class="form-control form-top-elem
        <?php if ($emailError) : ?>
           form-error
        <?php endif; ?>
      "> <!-- end input -->

    <?php if ($emailError) : ?>
      <div class="form-error-message">
        <?php echo $emailError; ?>
      </div>
    <?php endif; ?>


    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" placeholder="Password" required="" class="form-control form-bottom-elem"> <!-- end input -->

    <?php if ($passwordError) : ?>
      <div class=" form-error-message">
        <?php echo $passwordError; ?>
      </div>
    <?php endif; ?>


    <button class="confirm btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    <hr>
    <div>
      <h3 class="h4 mb-3 font-weight-normal">No account?</h3><a href="registration" class="login-registration-link"><u>Quick registration</u></a>
    </div>

  </form>

</main>
<?php include $this->resolve("partials/_footer.php"); ?>