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
    $this->validatorService->validateTransaction($_POST);
  }
}
