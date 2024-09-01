<?php
  session_start();
  
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $repeatedPassword = $_POST['repeatedPassword'];

  // username validation
  if (ctype_alnum($username) == false)
  {
    $_SESSION['error'] = 'registration_error';
    $_SESSION['errorMessage'] = 'Name must consist of alphanumeric characters only!';
    header("Location: registration.php");
    exit();
  }

  // email validation
  $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
  if ((filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)==false) || $email != $emailSanitized)
  {
    $_SESSION['error'] = 'registration_error';
    $_SESSION['errorMessage'] = 'email addres is not valid';
    header("Location: registration.php");
    exit();
  }

  // password validation
  if (strlen($password) < 8 || strlen($password) > 20)
  {
    $_SESSION['error'] = 'registration_error';
    $_SESSION['errorMessage'] = 'Password must be between 8 and 20 charaters';
    header("Location: registration.php");
    exit();
  }
  if ($password != $repeatedPassword)
  {
    $_SESSION['error'] = 'registration_error';
    $_SESSION['errorMessage'] = 'Passwords provided are different!';
    header("Location: registration.php");
    exit();
  }

  require_once "db.php";

  // check if email already exists in database
  $stmt = "SELECT * FROM user WHERE email='$email'";
  $query = $conn->query($stmt);  // conn active for the lifetime of that PDO object - closed automatically when all remaining references would be destroy
  $result = $query->fetch(PDO::FETCH_ASSOC);
  if ($result)
  {
    $_SESSION['error'] = 'registration_error';
    $_SESSION['errorMessage'] = "There is already an account associated with this email address!";
    header("Location: registration.php");
  } 
  else
  {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = "INSERT INTO user (email, password, username) VALUES ('$email', '$passwordHash', '$username')";
    $conn->query($stmt);
    $userId = $conn->lastInsertId();
    
    $stmt = "INSERT INTO user_income_category (user_id, name) SELECT '$userId', name FROM income_category_default";
    $conn->query($stmt);

    $stmt = "INSERT INTO user_expense_category (user_id, name) SELECT '$userId', name FROM expense_category_default";
    $conn->query($stmt);

    $stmt = "INSERT INTO user_payment_method (user_id, name) SELECT '$userId', name FROM payment_method_default";
    $conn->query($stmt);

    header("Location: login.php");
  }
?>
