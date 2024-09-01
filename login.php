<?php

	session_start();

	if (isset($_SESSION['userIsLogged']) && $_SESSION['userIsLogged']==true)
	{
    // LOG OUT
    session_destroy();
    header("Location: login.php");
    exit();
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>

  <header>

    <h1 >
      <a href="index.php" class="logo ">BudJet Manager</a>
    </h1>

  </header>

  <main>

    <form class="form" action="login_action.php" method="post">

      <h2 class="h3 mb-3 font-weight-normal">Please sign in</h2>
      
      <label for="inputEmail" class="sr-only">Email address</label>
      <input name="email" type="email" class="form-control form-top-elem" placeholder="Email address" required=""
        <?php
        if (isset($_SESSION['error']) && $_SESSION['error']=='login_error')
          echo 'style="border:1px solid #EB3F34;"';
        ?>
      >

      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" class="form-control form-bottom-elem" placeholder="Password" required=""
        <?php
        if (isset($_SESSION['error']) && $_SESSION['error']=='login_error')
          echo 'style="border:1px solid #EB3F34;"';
        ?>
      >

      <?php
      if (isset($_SESSION['error']) && $_SESSION['error']=='login_error')
      {
        echo '<div style="color: red; font-size: 15px; margin-bottom: 10px;">'."Invalid login or password".'</div>';
        unset($_SESSION['error']);
      }
      ?>
      
      <button class="confirm btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

      <hr>
      <div>no account?<br><a href="registration.php" class="login-registration-link"><u>Quick registration</u></a></div>

    </form>
    
  </main>

  <footer>
    <p class="text-muted">
      © BudJetManager 2024
    </p>
  </footer>

</body>
