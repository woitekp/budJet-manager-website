<?php
  require_once "db.php";

  session_start();
  
  $login = $_POST['email'];
  $password = $_POST['password'];
  
  $stmt = "SELECT * FROM user WHERE email='$login'";
  $query = $conn->query($stmt);  // conn active for the lifetime of that PDO object - closed automatically when all remaining references would be destroy
  $result = $query->fetch(PDO::FETCH_ASSOC);
  if ($result)
  {
    if (password_verify($password, $result['password']))
    {
      $_SESSION['userIsLogged'] = true;
      $_SESSION['userId'] = $result['id'];
      header("Location: index.php");
    }
    else
    {
      $_SESSION['error'] = 'login_error';
      header("Location: login.php");
    }
  } 
  else
  {
    $_SESSION['error'] = 'login_error';
    header("Location: login.php");
  }
?>
