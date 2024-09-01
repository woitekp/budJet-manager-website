<?php

	session_start();
	
	if (!(isset($_SESSION['userIsLogged']) && $_SESSION['userIsLogged']==true))
  {
    header('Location: login.php');
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
      <a href="index.php" class="logo">BudJet Manager</a>
    </h1>

    <ul class="menu">
      <li><a href="index.php">Home</a></li>
      <li><a class="selected-option" href="income.php">Add income</a></li>
      <li><a href="expense.php">Add Expense</a></li>
      <li><a href="#">Settings</a></li>
      <li><a href="balance.php">Show Balance</a></li>
      <li><a href="login.php">Sign out</a></li>
    </ul>

  </header>

  <main>

    <form class="form" action="income_action.php" method="post">

      <label for="inputAmount" class="sr-only">Amount</label>
      <input name="amount" type="number" min="0" step="0.01" class="form-control form-top-elem text-centered" placeholder="Amount" required="" autofocus="">

      <label for="inputDate" class="sr-only">Date</label>
      <input name="date" type="date" class="form-control form-middle-elem text-centered" value=<?php echo date("Y-m-d", time())?> required="">

      <label for="inputCategory" class="sr-only">Category</label>
      <select name="category" type="text" class="form-control form-middle-elem text-centered" placeholder="Select category" required="">
        <option value="" selected>Select category</option>
        <?php
        // get user categories from db
        $categories = array();
        require_once("db.php");
        $userId = $_SESSION['userId'];
        $stmt = "SELECT name FROM user_income_category WHERE user_id='$userId'";
        $query = $conn->query($stmt);
        while ($result = $query->fetch(PDO::FETCH_ASSOC))
        {
          array_push($categories, $result['name']);
        }
        natcasesort($categories); // order natural, case insensitive
        foreach ($categories as $item) {
          echo "<option>".$item."</option>";
        }
        ?>
      </select>

      <label for="inputComment" class="sr-only">Comment</label>
      <input name="comment" type="text" class="form-control form-bottom-elem text-centered" placeholder="Comment (optional)" autofocus="">

      <div class="grid-container">
        <button name="cancel" class="cancel left btn btn-lg btn-primary" type="submit">Cancel</button>
        <button name="add" class="confirm right btn btn-lg btn-primary btn-info " type="submit">Add income</button>
      </div>
    </form>

    <?php
      if (isset($_SESSION['msg']) && $_SESSION['msg']=='income_added')
      {
        echo '<div style="color: green; font-size: 25px;">'."Income added".'</div>';
        unset($_SESSION['msg']);
      }
    ?>

  </main>

  <footer>
    <p class="text-muted">
      © BudJetManager 2024
    </p>
  </footer>

</body>
