<?php include $this->resolve("partials/_header.php"); ?>

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

  <?php include $this->resolve("partials/_footer.php"); ?>
  