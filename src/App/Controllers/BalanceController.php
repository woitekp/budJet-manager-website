<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use App\Services\BalanceService;

class BalanceController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private BalanceService $balanceService
  ) {}

  public function balanceView()
  {
    $balancePeriod = addcslashes($_GET['balancePeriod'] ?? '', '%_');

    if ($balancePeriod == 'Previous month') {
      $startDate = date_create("first day of -1 month")->format('Y-m-d'); // first day of previous month
      $endDate = date_create("last day of -1 month")->format('Y-m-d'); // last day of previous month

    } else if ($balancePeriod == 'Current year') {
      $startDate = date('Y-01-01'); // first day of month
      $endDate = date('Y-12-31'); // first day of month

    } else if ($balancePeriod == 'Custom') {
      $startDate = addcslashes($_GET['startDate'] ?? '', '%_');
      $endDate = addcslashes($_GET['endDate'] ?? '', '%_');

      if ($startDate == '' || $endDate == '')
        $error = 'Provide dates for custom balance period';
      else if ($endDate < $startDate)
        $error = 'Second date must not be lower than the first date';
    } else {
      $balancePeriod == 'Current month';
      $startDate = date('Y-m-01'); // first day of month
      $endDate = date('Y-m-t'); // last day of month
    }

    $incomesByCategories = $this->balanceService->getUserIncomesByCategories($startDate, $endDate);
    $expensesByCategories = $this->balanceService->getUserExpensesByCategories($startDate, $endDate);
    $incomes = $this->balanceService->getUserIncomes($startDate, $endDate);
    $expenses = $this->balanceService->getUserExpenses($startDate, $endDate);

    echo $this->view->render('/balance/balance.php', [,
      'balancePeriod' => $balancePeriod,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'error' => $error ?? '',
      'incomesByCategories' => $incomesByCategories,
      'expensesByCategories' => $expensesByCategories,
      'incomes' => $incomes,
      'expenses' => $expenses
    ]);
  }
}
