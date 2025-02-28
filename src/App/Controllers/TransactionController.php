<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;

class TransactionController
{
  public function __construct(
    private TemplateEngine $view,
    private ValidatorService $validatorService
  ) {}

  public function expenseView()
  {
    echo $this->view->render("transactions/expense.php");
  }

  public function expense()
  {
    $this->validatorService->validateExpense($_POST);
  }

  public function incomeView()
  {
    echo $this->view->render("transactions/income.php");
  }

  public function income()
  {
    $this->validatorService->validateIncome($_POST);
  }
}
