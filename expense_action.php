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
    $payment = $_POST['payment'];
    $comment = $_POST['comment'];

    $stmt = "INSERT INTO expense (user_id, amount, date, category, payment_method, comment)
             VALUES (
              '$userId', '$amount', '$date',
              (SELECT id FROM user_expense_category WHERE user_id='$userId' and name='$category'),
              (SELECT id FROM user_payment_method WHERE user_id='$userId' and name='$payment'),
              '$comment'
             )";
    $conn->query($stmt);

    $_SESSION['msg'] = 'expense_added';
    header("Location: expense.php");
  }
  // user clicked "cancel" button - refresh page to clear the form
  else if (isset($_POST['cancel']))
  {  
    header("Location: expense.php");
  }

?>
