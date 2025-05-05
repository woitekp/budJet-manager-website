<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\{Database, TemplateEngine};
use Framework\Exceptions\ValidationException;
use App\Services\{IncomeService, ExpenseService, PaymentService, ValidatorService};


class SettingsController
{
  public function __construct(
    private Database $db,
    private TemplateEngine $view,
    private IncomeService $incomeService,
    private ExpenseService $expenseService,
    private PaymentService $paymentService,
    private ValidatorService $validatorService
  ) {}

  public function settingsView()
  {
    $incomesCategories = $this->incomeService->getUserIncomeCategories(enumerate: true);
    $expenseCategories = $this->expenseService->getUserExpenseCategories(enumerate: true);
    $paymentMethods = $this->paymentService->getUserPaymentMethods(enumerate: true);
    echo $this->view->render('/settings/list.php', [
      'incomesCategories' => $incomesCategories,
      'expenseCategories' => $expenseCategories,
      'paymentMethods' => $paymentMethods
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

  public function editPaymentMethodView(array $params)
  {
    $paymentMethod = $this->paymentService->getUserPaymentMethod((int) $params['method_id']);

    if (!$paymentMethod) {
      redirectTo('/settings');
    }

    echo $this->view->render('/settings/edit.php', [
      'name' => $paymentMethod['name']
    ]);
  }

  public function editPaymentMethod(array $params)
  {
    $paymentMethod = $this->paymentService->getUserPaymentMethod((int) $params['method_id']);
    if (!$paymentMethod) {
      redirectTo('/settings');
    }

    $this->validatorService->validateCategory($_POST);

    if ($this->paymentService->userPaymentMethodExists($_POST['name'])) {
      throw new ValidationException(['name' => ['Payment method already exists']]);
    }

    $this->paymentService->updatePaymentMethod($_POST, $paymentMethod['id']);

    redirectTo(
      $_SERVER['HTTP_REFERER']
    );
  }

  public function deletePaymentMethod(array $params)
  {
    if ($this->expenseService->countExpensesWithPaymentMethod((int) $params['method_id'])) {
      throw new ValidationException(['name' => ['There are expenses with this payment method. Delete these expenses first']]);
    }

    $this->paymentService->deletePaymentMethod((int) $params['method_id']);
    redirectTo('/settings');
  }

  public function createCategory()
  {

    if (isset($_POST['incomeCategory']))
      $this->createIncomeCategory($_POST['incomeCategory']);
    elseif (isset($_POST['expenseCategory']))
      $this->createExpenseCategory($_POST['expenseCategory']);
    elseif (isset($_POST['paymentMethod']))
      $this->createPaymentMethod($_POST['paymentMethod']);

    redirectTo('/settings');
  }

  private function createIncomeCategory($name)
  {
    $name = ucwords(
      strtolower($name)
    );

    $this->validatorService->validateCategory(
      [
        'name' => $name
      ]
    );

    if ($this->incomeService->userIncomeCategoryExists($name)) {
      throw new ValidationException(['name' => ['Category "' . $name . '" already exists']]);
    }

    $this->incomeService->createIncomeCategory($name);
  }

  private function createExpenseCategory($name)
  {
    $name = ucwords(
      strtolower($name)
    );

    $this->validatorService->validateCategory(
      [
        'name' => $name
      ]
    );

    if ($this->expenseService->userExpenseCategoryExists($name)) {
      throw new ValidationException(['name' => ['Category "' . $name . '" already exists']]);
    }

    $this->expenseService->createExpenseCategory($name);
  }

  private function createPaymentMethod($name)
  {
    $name = ucwords(
      strtolower($name)
    );

    $this->validatorService->validateCategory(
      [
        'name' => $name
      ]
    );

    if ($this->paymentService->userPaymentMethodExists($name)) {
      throw new ValidationException(['name' => ['Category "' . $name . '" already exists']]);
    }

    $this->paymentService->createPaymentMethod($name);
  }
}
