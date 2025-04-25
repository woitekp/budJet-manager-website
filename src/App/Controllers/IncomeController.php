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
    $searchTerm = addcslashes($_GET['s'] ?? '', '%_');

    $currentPage = $_GET['p'] ?? 1;
    $currentPage = (int) $currentPage;
    $length = 3;
    $offset = ($currentPage - 1) * $length;

    $incomes = $this->incomeService->getUserIncomes($length, $offset, $searchTerm);
    if ($incomes)
      $lastPage = ceil($incomes[0]['records_count'] / $length);
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

    echo $this->view->render("incomes/list.php", [
      'incomes' => $incomes,
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

  public function addIncomeView()
  {
    $categories = $this->incomeService->getUserIncomeCategories();

    echo $this->view->render("incomes/create.php", [
      'categories' => $categories
    ]);
  }

  public function createIncome()
  {
    $this->validatorService->validateIncome($_POST);
    $this->incomeService->createIncome($_POST);
    redirectTo('/incomes');
  }

  public function editIncomeView(array $params)
  {
    $income = $this->incomeService->getUserIncome((int) $params['income_id']);
    if (!$income) {
      redirectTo('/incomes');
    }

    $categories = $this->incomeService->getUserIncomeCategories();
    echo $this->view->render('/incomes/edit.php', [
      'income' => $income,
      'categories' => $categories
    ]);
  }

  public function editIncome(array $params)
  {
    $income = $this->incomeService->getUserIncome((int) $params['income_id']);
    if (!$income) {
      redirectTo('/incomes');
    }

    $this->validatorService->validateIncome($_POST);
    $this->incomeService->updateIncome($_POST, $income['id']);
    redirectTo($_SERVER['HTTP_REFERER']);
  }

  public function deleteIncome(array $params)
  {
    $this->incomeService->deleteIncome((int) $params['income_id']);
    redirectTo('/incomes');
  }
}
