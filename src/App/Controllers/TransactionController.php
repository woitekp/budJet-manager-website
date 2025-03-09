<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use App\Services\{TransactionService, ValidatorService};

class TransactionController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private TransactionService $transactionService,
    private ValidatorService $validatorService
  ) {}

  public function expenseView()
  {
    $categories = $this->transactionService->getUserExpenseCategories();
    $paymentMethods = $this->transactionService->getuserPaymentMethods();

    echo $this->view->render("transactions/expense.php", [
      'categories' => $categories,
      'paymentMethods' => $paymentMethods
    ]);
  }

  public function expense()
  {
    $this->validatorService->validateExpense($_POST);
    $this->transactionService->createExpense($_POST);
    redirectTo('/');
  }

  public function incomeView()
  {
    $categories = $this->transactionService->getUserIncomeCategories();

    echo $this->view->render("transactions/income.php", [
      'categories' => $categories
    ]);
  }

  public function income()
  {
    $this->validatorService->validateIncome($_POST);
    $this->transactionService->createIncome($_POST);
    redirectTo('/');
  }
}
