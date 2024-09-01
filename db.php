<?php

  $host = "localhost";
  $db_name = "personal_budget";
  $dsn = "mysql:dbname={$db_name};host={$host}";
  $db_user = "root";
  $db_password = "";
  
  try {
    $conn = new PDO(
      $dsn,
      $db_user,
      $db_password,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // Error reporting mode of PDO => Throw PDOExceptions.
      ]
    );
  } catch (Exception $e) {
    echo "Error have occured. Try again later.";
  }
?>
