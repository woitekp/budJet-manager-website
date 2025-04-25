<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use Framework\Exceptions\ValidationException;
use App\Services\{IncomeService, ExpenseService, SettingsService, ValidatorService};


class SettingsController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private IncomeService $incomeService,
    private ExpenseService $expenseService,
    private ValidatorService $validatorService
  ) {}

  public function settingsView()
  {
    $incomesCategories = $this->incomeService->getUserIncomeCategories(enumerate: true);
    $expenseCategories = $this->expenseService->getUserExpenseCategories(enumerate: true);
    echo $this->view->render('/settings/list.php', [
      'incomesCategories' => $incomesCategories,
      'expenseCategories' => $expenseCategories
    ]);
  }

  public function editIncomeCategoryView(array $params)
  {
    $incomeCategory = $this->incomeService->getUserIncomeCategory((int) $params['category_id']);

    if (!$incomeCategory) {
      redirectTo('/settings');
    }

    echo $this->view->render('/settings/edit.php', [
      'name' => $incomeCategory['name']
    ]);
  }

  public function editIncomeCategory(array $params)
  {
    $incomeCategory = $this->incomeService->getUserIncomeCategory((int) $params['category_id']);
    if (!$incomeCategory) {
      redirectTo('/settings');
    }

    $this->validatorService->validateCategory($_POST);

    if ($this->incomeService->userIncomeCategoryExists($_POST['name'])) {
      throw new ValidationException(['name' => ['Category already exists']]);
    }

    $this->incomeService->updateIncomeCategory($_POST, $incomeCategory['id']);

    redirectTo(
      $_SERVER['HTTP_REFERER']
    );
  }

  public function deleteIncomeCategory(array $params)
  {
    if ($this->incomeService->countIncomesInCategory((int) $params['category_id'])) {
      throw new ValidationException(['name' => ['There are incomes with this category. Delete these incomes first']]);
    }

    $this->incomeService->deleteIncomeCategory((int) $params['category_id']);
    redirectTo('/settings');
  }

  public function editExpenseCategoryView(array $params)
  {
    $expenseCategory = $this->expenseService->getUserExpenseCategory((int) $params['category_id']);

    if (!$expenseCategory) {
      redirectTo('/settings');
    }

    echo $this->view->render('/settings/edit.php', [
      'name' => $expenseCategory['name']
    ]);
  }

  public function editExpenseCategory(array $params)
  {
    $expenseCategory = $this->expenseService->getUserExpenseCategory((int) $params['category_id']);
    if (!$expenseCategory) {
      redirectTo('/settings');
    }

    $this->validatorService->validateCategory($_POST);

    if ($this->expenseService->userExpenseCategoryExists($_POST['name'])) {
      throw new ValidationException(['name' => ['Category already exists']]);
    }

    $this->expenseService->updateExpenseCategory($_POST, $expenseCategory['id']);

    redirectTo(
      $_SERVER['HTTP_REFERER']
    );
  }

  public function deleteExpenseCategory(array $params)
  {
    if ($this->expenseService->countExpensesInCategory((int) $params['category_id'])) {
      throw new ValidationException(['name' => ['There are expenses with this category. Delete these expenses first']]);
    }

    $this->expenseService->deleteExpenseCategory((int) $params['category_id']);
    redirectTo('/settings');
  }
}
