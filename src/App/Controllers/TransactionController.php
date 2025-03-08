<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, ValidatorService};

class TransactionController
{
  public function __construct(
    private TemplateEngine $view,
    private TransactionService $transactionService,
    private ValidatorService $validatorService
  ) {}

  public function expenseView()
  {
    echo $this->view->render("transactions/expense.php");
  }

  public function expense()
  {
    $this->validatorService->validateExpense($_POST);
    $this->transactionService->createExpense($_POST);
    redirectTo('/');
  }

  public function incomeView()
  {
    echo $this->view->render("transactions/income.php");
  }

  public function income()
  {
    $this->validatorService->validateIncome($_POST);
    $this->transactionService->createIncome($_POST);
    redirectTo('/');
  }
}
