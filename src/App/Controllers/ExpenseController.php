<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use App\Services\{ExpenseService, ValidatorService};

class ExpenseController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private ExpenseService $expenseService,
    private ValidatorService $validatorService
  ) {}

  public function expensesView()
  {
    $expenses = $this->expenseService->getUserExpenses();
    echo $this->view->render("transactions/expenses.php", [
      'expenses' => $expenses
    ]);
  }

  public function addExpenseView()
  {
    $categories = $this->expenseService->getUserExpenseCategories();
    $paymentMethods = $this->expenseService->getuserPaymentMethods();

    echo $this->view->render("transactions/expense.php", [
      'categories' => $categories,
      'paymentMethods' => $paymentMethods
    ]);
  }

  public function createExpense()
  {
    $this->validatorService->validateExpense($_POST);
    $this->expenseService->createExpense($_POST);
    redirectTo('/expenses');
  }
}
