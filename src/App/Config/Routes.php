<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
  AboutController,
  AuthController,
  BalanceController,
  ExpenseController,
  HomeController,
  IncomeController,
  SettingsController
};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app)
{
  $app->get('/', [HomeController::class, 'home'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('/about', [AboutController::class, 'about']);

  $app->get('/registration', [AuthController::class, 'registerView'])->addRouteMiddleware(GuestOnlyMiddleware::class);
  $app->post('/registration', [AuthController::class, 'register'])->addRouteMiddleware(GuestOnlyMiddleware::class);

  $app->get('/login', [AuthController::class, 'loginView'])->addRouteMiddleware(GuestOnlyMiddleware::class);
  $app->post('/login', [AuthController::class, 'login'])->addRouteMiddleware(GuestOnlyMiddleware::class);

  $app->get('/logout', [AuthController::class, 'logout'])->addRouteMiddleware(AuthRequiredMiddleware::class);


  $app->get('/expense', [ExpenseController::class, 'addExpenseView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/expense', [ExpenseController::class, 'createExpense'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/expenses', [ExpenseController::class, 'expensesView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('expenses/{expense_id}', [ExpenseController::class, 'editExpenseView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('expenses/{expense_id}', [ExpenseController::class, 'editExpense'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->delete('expenses/{expense_id}', [ExpenseController::class, 'deleteExpense'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/income', [IncomeController::class, 'addIncomeView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/income', [IncomeController::class, 'createIncome'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/incomes', [IncomeController::class, 'incomesView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('incomes/{income_id}', [IncomeController::class, 'editIncomeView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('incomes/{income_id}', [IncomeController::class, 'editIncome'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->delete('incomes/{income_id}', [IncomeController::class, 'deleteIncome'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/balance', [BalanceController::class, 'balanceView'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/settings', [SettingsController::class, 'settingsView'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/settings/incomes/{category_id}', [SettingsController::class, 'editIncomeCategoryView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/settings/incomes/{category_id}', [SettingsController::class, 'editIncomeCategory'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->delete('/settings/incomes/{category_id}', [SettingsController::class, 'deleteIncomeCategory'])->addRouteMiddleware(AuthRequiredMiddleware::class);

  $app->get('/settings/expenses/{category_id}', [SettingsController::class, 'editExpenseCategoryView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/settings/expenses/{category_id}', [SettingsController::class, 'editExpenseCategory'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->delete('/settings/expenses/{category_id}', [SettingsController::class, 'deleteExpenseCategory'])->addRouteMiddleware(AuthRequiredMiddleware::class);
}
