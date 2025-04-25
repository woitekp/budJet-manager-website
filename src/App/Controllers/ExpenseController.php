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
    $searchTerm = addcslashes($_GET['s'] ?? '', '%_');

    $currentPage = $_GET['p'] ?? 1;
    $currentPage = (int) $currentPage;
    $length = 3;
    $offset = ($currentPage - 1) * $length;

    $expenses = $this->expenseService->getUserExpenses($length, $offset, $searchTerm);
    if ($expenses)
      $lastPage = ceil($expenses[0]['records_count'] / $length);
    else
      $lastPage = 1;

    $pageNums = range(1, $lastPage);

    $pageLinks = array_map(
      fn($pageNum) => http_build_query([
        'p' => $pageNum,
        's' => $searchTerm
      ]),
      $pageNums
    );

    echo $this->view->render("expenses/list.php", [
      'expenses' => $expenses,
      'currentPage' => $currentPage,
      'lastPage' => $lastPage,
      'previousPageQuery' => http_build_query([
        'p' => $currentPage - 1,
        's' => $searchTerm
      ]),
      'nextPageQuery' => http_build_query([
        'p' => $currentPage + 1,
        's' => $searchTerm
      ]),
      'pageLinks' => $pageLinks,
      'searchTerm' => $searchTerm
    ]);
  }

  public function addExpenseView()
  {
    $categories = $this->expenseService->getUserExpenseCategories();
    $paymentMethods = $this->expenseService->getUserPaymentMethods();

    echo $this->view->render("expenses/create.php", [
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

  public function editExpenseView(array $params)
  {
    $expense = $this->expenseService->getUserExpense((int) $params['expense_id']);
    if (!$expense) {
      redirectTo('/expenses');
    }

    $categories = $this->expenseService->getUserExpenseCategories();
    $paymentMethods = $this->expenseService->getUserPaymentMethods();
    echo $this->view->render('/expenses/edit.php', [
      'expense' => $expense,
      'categories' => $categories,
      'paymentMethods' => $paymentMethods
    ]);
  }

  public function editExpense(array $params)
  {
    $expense = $this->expenseService->getUserExpense((int) $params['expense_id']);
    if (!$expense) {
      redirectTo('/expenses');
    }

    $this->validatorService->validateExpense($_POST);
    $this->expenseService->updateExpense($_POST, $expense['id']);
    redirectTo($_SERVER['HTTP_REFERER']);
  }

  public function deleteExpense(array $params)
  {
    $this->expenseService->deleteExpense((int) $params['expense_id']);
    redirectTo('/expenses');
  }
}
