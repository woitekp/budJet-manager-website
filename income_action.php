<?php

  require_once("db.php");

  session_start();

  // if user added inconme
  if (isset($_POST['add']))
  {
    $userId = $_SESSION['userId'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $comment = $_POST['comment'];
    
    $stmt = "INSERT INTO income (user_id, amount, date, category, comment)
             VALUES (
              '$userId', '$amount', '$date',
              (SELECT id FROM user_income_category WHERE user_id='$userId' and name='$category'),
              '$comment'
             )";
    $conn->query($stmt);
  
    $_SESSION['msg'] = 'income_added';
    header("Location: income.php");
  }
  // user clicked "cancel" button - refresh page to clear the form
  else if (isset($_POST['cancel']))
  {  
    header("Location: income.php");
  }
?>
