<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, RegistrationController};


function registerRoutes(App $app)
{
  $app->get('/', [HomeController::class, 'home']);
  $app->get('/about', [AboutController::class, 'about']);
  $app->get('/registration', [RegistrationController::class, 'registerView']);
  $app->post('/registration', [RegistrationController::class, 'register']);
}
