<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
  AboutController,
  AuthController,
  ExpenseController,
  HomeController,
  IncomeController
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
  $app->get('/income', [IncomeController::class, 'addIncomeView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/income', [IncomeController::class, 'createIncome'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('/incomes', [IncomeController::class, 'incomesView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('incomes/{income_id}', [IncomeController::class, 'editIncomeView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('incomes/{income_id}', [IncomeController::class, 'editIncome'])->addRouteMiddleware(AuthRequiredMiddleware::class);
}
