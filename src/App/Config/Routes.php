<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
  AboutController,
  AuthController,
  HomeController,
  TransactionController
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
  $app->get('/expense', [TransactionController::class, 'expenseView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/expense', [TransactionController::class, 'expense'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->get('/income', [TransactionController::class, 'incomeView'])->addRouteMiddleware(AuthRequiredMiddleware::class);
  $app->post('/income', [TransactionController::class, 'income'])->addRouteMiddleware(AuthRequiredMiddleware::class);
}
