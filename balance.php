<?php

	session_start();
	
	if (!(isset($_SESSION['userIsLogged']) && $_SESSION['userIsLogged']==true))
  {
    header('Location: login.php');
    exit();
  }

  if (isset($_SESSION['balancePeriod']))
  {
    $balancePeriod = $_SESSION['balancePeriod'];
    unset($_SESSION['balancePeriod']);
  }
  else if (isset($_GET['startDate']) && isset($_GET['end']))
  {
    $balancePeriod = 'custom';
  }
  else
  {
    $balancePeriod = 'currentMonth';
  }

  if ($balancePeriod == 'currentMonth')
  {
    $startDate = date('Y-m-01'); // first day of month
    $endDate = date('Y-m-t'); // last day of month
  }
  else if ($balancePeriod == 'previousMonth')
  {
    $startDate = date_create("first day of -1 month")->format('Y-m-d'); // first day of previous month
    $endDate = date_create("last day of -1 month")->format('Y-m-d'); // last day of previous month
  }
  else if ($balancePeriod == 'currentYear')
  {
    $startDate = date('Y-01-01'); // first day of month
    $endDate = date('Y-12-31'); // first day of month
  }
  else if ($balancePeriod == 'custom')
  {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
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

    <ul class="menu">
      <li><a href="index.php">Home</a></li>
      <li><a href="income.php">Add income</a></li>
      <li><a href="expense.php">Add Expense</a></li>
      <li><a href="#">Settings</a></li>
      <li><a class="selected-option" href="balance.php">Show Balance</a></li>
      <li><a href="login.php">Sign out</a></li>
    </ul>

  </header>

  <main>
    
    <form class="form" action="balance_action.php" method="post">
      <label for="inputPeriod" class="sr-only">Period</label>
      <select name="balancePeriod" type="text" id="selectPeriod" class="form-control form-bottom-elem text-centered"  placeholder="Select Period" required="">
        <option <?php if ($balancePeriod == 'currentMonth') {echo 'selected';} ?> >Current month</option>
        <option <?php if ($balancePeriod == 'previousMonth') {echo 'selected';} ?>>Previous month</option>
        <option <?php if ($balancePeriod == 'currentYear') {echo 'selected';} ?>>Current year</option>
        <option <?php if ($balancePeriod == 'custom') {echo 'selected';} ?>>Custom</option>
      </select>

      <!-- TODO with JS: hide date inputs if not custom option selected -->
      <label>Date range for custom period:</label>
        <input name="startDate" type="date" class="form-control form-middle-elem text-centered" value=<?php {echo $startDate;} ?>>
        <input name="endDate" type="date" class="form-control form-bottom-elem text-centered" value=<?php {echo $endDate;} ?>>
      <div>
        <button name="submit" class="confirm center btn btn-lg btn-primary btn-info" type="submit">Submit</button>
      </div>
    </form>

    <?php
      if (isset($_SESSION['error']))
      {
        if ($_SESSION['error']=='custom_period_balance_no_dates')
          $msg = "Provide dates for custom balance period";
        else if ($_SESSION['error']=='custom_period_balance_end_date_lower')
          $msg = "Second date must not be lower than the first date";
        echo '<div style="color: red; font-size: 25px;">'.$msg.'</div>';
        unset($_SESSION['error']);
        unset($_SESSION['balancePeriod']);
      }
    ?>

    <table>

      <caption>Incomes</caption>

      <tr class="column_names row_light">
        <th>Category</th>
        <th>Amount</th>
      </tr>

      <?php
        // get user incomes by category from db
        require_once("db.php");

        $userId = $_SESSION['userId'];

        $stmt =
          "SELECT
            user_income_category.name as category_name,
            COALESCE(SUM(income.amount), 0) AS category_sum,
            SUM(COALESCE(SUM(income.amount), 0))
              OVER (ORDER BY category_sum DESC, category_name ASC) AS running_category_sum
          FROM user_income_category
          LEFT JOIN
            (SELECT * FROM income WHERE date BETWEEN '$startDate' AND '$endDate') AS income
          ON user_income_category.id = income.category
          WHERE user_income_category.user_id = '$userId'
          GROUP BY category_name
          ORDER BY category_sum DESC, category_name ASC";
          $query = $conn->query($stmt);

        $rowStyle = "row_dark";
        $incomesSum = 0;
        while ($result = $query->fetch(PDO::FETCH_ASSOC))
        {
          echo
          '<tr class="'.$rowStyle.'">
            <th>'.$result['category_name'].'</th>
            <th>'.$result['category_sum'].'</th>
          </tr>';
          
          $incomesSum = $result['running_category_sum'];

          $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
        }
        echo
        '<tr class="'.$rowStyle.' summary">
          <th>SUM</th>
          <th>'.$incomesSum.'</th>
        </tr>';
      ?>
      
    </table>

    <table>

      <caption>Expenses</caption>

      <tr class="column_names row_light">
        <th>Category</th>
        <th>Amount</th>
      </tr>

      <?php
        // get user expenses by category from db
        $stmt =
          "SELECT
            expense.category as category,
            user_expense_category.name as category_name,
            COALESCE(SUM(expense.amount), 0) AS category_sum,
            SUM(COALESCE(SUM(expense.amount), 0))
              OVER (ORDER BY category_sum DESC, category_name ASC) AS running_category_sum
          FROM user_expense_category
          LEFT JOIN
            (SELECT * FROM expense WHERE date BETWEEN '$startDate' AND '$endDate') AS expense
          ON user_expense_category.id = expense.category
          WHERE user_expense_category.user_id = '$userId'
          GROUP BY category_name
          ORDER BY category_sum DESC, category_name ASC";
        $query = $conn->query($stmt);

        $expenses = array();
        $rowStyle = "row_dark";
        $expensesSum = 0;
        while ($result = $query->fetch(PDO::FETCH_ASSOC))
        {
          echo
          '<tr class="'.$rowStyle.'">
            <th>'.$result['category_name'].'</th>
            <th>'.$result['category_sum'].'</th>
          </tr>';

          $expensesSum = $result['running_category_sum'];

          $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";

          if ($result['category_sum'] > 0)
            array_push($expenses, $result);
        }
        echo
        '<tr class="'.$rowStyle.' summary">
          <th>SUM</th>
          <th>'.$expensesSum.'</th>
        </tr>';
      ?>

    </table>

    <?php
    
    // pie chart for expenses - display only when any expense exist 
    if ($expensesSum > 0)  
    {
      // background for pie chart - i.e.:
      // background: conic-gradient(rgb(68, 44, 1) 0 50%, rgb(176, 84, 113) 0 75%,  rgb(176, 84, 113) 0)
      // '0' after rgb() 0 makes edges sharp and percentage determines filling ratio
      $background = 'background: conic-gradient('; 
      $i = 0;
      foreach($expenses as &$expense)  // pass elements by reference with & operator as it is modified in loop
      {
        // add comma after every item excluding the last one (e.g. before every item beside first one)
        if ($i > 0) $background = $background.', ';

        // get different color for every category - i.e.: rgb(68, 44, 1)
        $color = 'rgb(';
        $hash = md5($expense['category_name']);
        // get consecutive 2 chars from hash -> convert from hex to dec -> use as a consecutive RGB coordinates
        for ($j = 0; $j <= 4; $j += 2)
        {
          $color = $color.(string)(hexdec(substr($hash, $j, 2)));
          if ($j < 4) $color = $color.', '; // add comma after every item exluding the last one
        }
        $color = $color.')';

        // save color for chart legend
        $expense['color'] = $color;

        // add color, '0' (for sharp edges) and percentage to background style
        $background = $background.$color.' 0 '.($expense['running_category_sum'] / $expensesSum * 100).'%';
        $i++;
      }
      $background = $background.')';

      // Break the reference with the last element.
      // For the rationale behind this see the manual ->
      // https://www.php.net/manual/en/control-structures.foreach.php (warning section)
      unset($expense);

      // get padding for chart legend 
      define("pieChartHeight", 450);  // value set in main.css - if changed, both pieChartHeight and css value must be changed
      define("maxElementsCountInColumn", 16);
      $legendColumnsCount = ceil(count($expenses) / (maxElementsCountInColumn));
      // equal number of elements in every column would b e displayed
      // e.g. if thera are 17 elements, in first column there would be 9 items, and in the second one - 8 items
      $elementsOnColumnCount = ceil(count($expenses) / $legendColumnsCount); 
      $proportionOfFreeSpaceInLegendColumn = 1 - $elementsOnColumnCount / maxElementsCountInColumn;
      $pixelsOfFreeSpaceInLegendColumn = pieChartHeight * $proportionOfFreeSpaceInLegendColumn;
      $legendPaddingTop = $pixelsOfFreeSpaceInLegendColumn / 2;
      $paddingStyle = 'style="padding-top: '.$legendPaddingTop.'px;"';
     
      echo
      '<div class="chart">
        <div class="pie_chart" style="'.$background.';">';
        // display legend
        $i = 0;
        foreach($expenses as $expense)
        {
          // if new legend column is starting then close last div and open new legend column
          if ($i % $elementsOnColumnCount == 0) 
          {
            // check if element is in last legend column to set proper margin-right (see legend_last_column in main.css)
            $lastLegendColumnStyle = ($i >= (($legendColumnsCount-1)*$elementsOnColumnCount)) ? ' legend_last_column' : '';
            echo '</div><div class="legend'.$lastLegendColumnStyle.'" '.$paddingStyle.'>';
          }
          $expensePercentage = round($expense['category_sum'] / $expensesSum * 100, 0);
          echo
          '<div class="legend_item">
            <div class="item_color" style="background-color: '.$expense['color'].';"></div>
            <div class="item_text">'.$expense['category_name'].' '.$expensePercentage.'%</div>
          </div>';
          $i++;
        }
        echo  // close chart
      '</div></div>';
    }
    ?>
  
  <table style="margin-top: 50px;">

      <caption>Incomes details</caption>

      <tr class="column_names row_light">
        <th>#</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Comment</th>
      </tr>

      <?php
        // get user incomes
        // notice the reversed sort order in ROW_NUMBER OVER compared to the ORDER BY clause
        // - as records are displayed in reversed order (from the newest)
        $stmt = "SELECT income.amount, income.date, user_income_category.name AS category_name, income.comment,
                  ROW_NUMBER() OVER (ORDER BY income.date, income.id) AS ordinal_number
                FROM income
                INNER JOIN user_income_category ON income.category=user_income_category.id
                WHERE income.user_id='$userId' AND (income.date BETWEEN '$startDate' AND '$endDate')
                ORDER BY income.date DESC, income.id DESC";
        $query = $conn->query($stmt);

        while ($result = $query->fetch(PDO::FETCH_ASSOC))
        {
          $ordinalNumber = $result['ordinal_number'];
          echo
          '<tr class="'.$rowStyle.'">
            <th class="number">'.$ordinalNumber.'</th>
            <th>'.$result['date'].'</th>
            <th>'.$result['amount'].'</th>
            <th>'.$result['category_name'].'</th>
            <th>'.$result['comment'].'</th>
          </tr>';


          $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
        }

      ?>

    </table>

    <table>

      <caption>Expenses details</caption>

      <tr class="column_names row_light">
        <th>#</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Payment<br>method</th>
        <th>Comment</th>
      </tr>

      <?php
        // get user expenses
        // notice the reversed sort order in ROW_NUMBER OVER compared to the ORDER BY clause
        // - as records are displayed in reversed order (from the newest)
        $stmt = "SELECT expense.amount, expense.date, user_payment_method.name as payment_method,
                  user_expense_category.name AS category_name, expense.comment,
                  ROW_NUMBER() OVER (ORDER BY expense.date, expense.id) AS ordinal_number
                FROM expense
                INNER JOIN user_expense_category ON expense.category=user_expense_category.id
                INNER JOIN user_payment_method ON expense.payment_method=user_payment_method.id
                WHERE expense.user_id='$userId' AND (expense.date BETWEEN '$startDate' AND '$endDate')
                ORDER BY expense.date DESC, expense.id DESC";
        $query = $conn->query($stmt);
        
        while ($result = $query->fetch(PDO::FETCH_ASSOC))
        {
          $ordinalNumber = $result['ordinal_number'];
          echo
          '<tr class="'.$rowStyle.'">
            <th class="number">'.$ordinalNumber.'</th>
            <th>'.$result['date'].'</th>
            <th>'.$result['amount'].'</th>
            <th>'.$result['category_name'].'</th>
            <th>'.$result['payment_method'].'</th>
            <th>'.$result['comment'].'</th>
          </tr>';

          $rowStyle = ($rowStyle == "row_light") ? "row_dark" : "row_light";
        }
      ?>

    </table>

  </main>

  <footer>
    <p class="text-muted">
      © BudJetManager 2024
    </p>
  </footer>

</body>
