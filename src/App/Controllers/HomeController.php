<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\TransactionService;
use Traversable;

class HomeController
{
  public function __construct(
    private TemplateEngine $view,
    private TransactionService $transactionService
  ) {}

  public function home()
  {
    $expenses = $this->transactionService->getUserExpenses();
    $incomes = $this->transactionService->getUserIncomes();
    echo $this->view->render('/index.php', [
      'expenses' => $expenses,
      'incomes' => $incomes
    ]);
  }
}
