<?php
  session_start();

  $getParams = '';

  if ($_POST['balancePeriod'] == 'Current month') {
    $_SESSION['balancePeriod'] = 'currentMonth';
  }
  else if ($_POST['balancePeriod'] == 'Previous month')
  {
    $_SESSION['balancePeriod'] = 'previousMonth';
  }
  else if ($_POST['balancePeriod'] == 'Current year')
  {
    $_SESSION['balancePeriod'] = 'currentYear';
  }
  else if ($_POST['balancePeriod'] == 'Custom')
  {
    $_SESSION['balancePeriod'] = 'custom';

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if ($startDate == '' || $endDate == '')
      $_SESSION['error'] = 'custom_period_balance_no_dates';
    if ($endDate < $startDate)
    {
      $_SESSION['error'] = 'custom_period_balance_end_date_lower';
    }

    $getParams = '?startDate='.$startDate.'&endDate='.$endDate;
  }

  header("Location: balance.php".$getParams);
?>
