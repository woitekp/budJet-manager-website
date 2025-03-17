<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use App\Services\{IncomeService, ValidatorService};

class IncomeController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private IncomeService $incomeService,
    private ValidatorService $validatorService
  ) {}

  public function incomesView()
  {
    $incomes = $this->incomeService->getUserIncomes();
    echo $this->view->render("transactions/incomes.php", [
      'incomes' => $incomes
    ]);
  }

  public function addIncomeView()
  {
    $categories = $this->incomeService->getUserIncomeCategories();

    echo $this->view->render("transactions/income.php", [
      'categories' => $categories
    ]);
  }

  public function createIncome()
  {
    $this->validatorService->validateIncome($_POST);
    $this->incomeService->createIncome($_POST);
    redirectTo('/incomes');
  }
}
