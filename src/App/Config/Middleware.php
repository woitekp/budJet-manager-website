<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{
  FlashMiddleware,
  SessionMiddleware,
  TemplateDataMiddleware,
  ValidationExceptionMiddleware,
};


function registerMiddleware(App $app)
{
  $app->addMiddleware(TemplateDataMiddleware::class);
  $app->addMiddleware(ValidationExceptionMiddleware::class);
  $app->addMiddleware(FlashMiddleware::class);
  $app->addMiddleware(SessionMiddleware::Class);  // middleware registered last is executed first
}
