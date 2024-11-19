<?php
  $usernameError = escape($errors['username'][0] ?? '');
  $emailError = escape($errors['email'][0] ?? '');
  $passwordError = escape($errors['password'][0] ?? '');
  $confirmPasswordError = escape($errors['confirmPassword'][0] ?? '');

  $username = escape($providedFormData['username'] ?? '');
  $email = escape($providedFormData['email'] ?? '');
?>


<?php include $this->resolve("partials/_header.php"); ?>

<main>

    <form class="form" method="post">

      <h2 class="h3 mb-3 font-weight-normal">Registration</h2>

      <label for="inputName" class="sr-only">Name</label>
      <input value="<?php echo $username; ?>" name="username" type="name" placeholder="Name" required="" autofocus="" class="form-control form-top-elem
        <?php if ($usernameError) : ?>
           form-error
        <?php endif;?>
      "> <!-- end input -->

      <?php if ($usernameError) : ?>
        <div class="form-error-message">
          <?php echo $usernameError; ?>
        </div>
      <?php endif; ?>


      <label for="inputEmail" class="sr-only">Email address</label>
      <input value="<?php echo $email; ?>" name="email" type="email" placeholder="Email address" required="" class="form-control form-middle-elem
        <?php if ($emailError) : ?>
            form-error
          <?php endif;?>
      "> <!-- end input -->

      <?php if ($emailError) : ?>
        <div class="form-error-message">
          <?php echo $emailError; ?>
        </div>
      <?php endif; ?>



      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" placeholder="Password" required="" class="form-control form-middle-elem
        <?php if ($passwordError) : ?>
          form-error
        <?php endif;?>
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
        <?php endif;?>
      "> <!-- end input -->

      <?php if ($confirmPasswordError) : ?>
        <div class="form-error-message">
          <?php echo $confirmPasswordError; ?>
        </div>
      <?php endif; ?>


      <button class="confirm btn btn-lg btn-primary btn-block" type="submit">Sign up</button>

      <hr>

      <div>or<br><a href="login.php" class="login-registration-link"><u>Sign in</u></a></div>

    </form>

  </main>


<?php include $this->resolve("partials/_footer.php"); ?>
