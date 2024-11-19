<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;


class FlashMiddleware implements MiddlewareInterface
{
  public function __construct(private TemplateEngine $view)
  {
  }

  public function process(callable $next)
  {
    $this->view->addGlobalTemplateData('errors', $_SESSION['errors'] ?? []);
    unset($_SESSION['errors']);

    $this->view->addGlobalTemplateData('providedFormData', $_SESSION['providedFormData'] ?? []);
    unset($_SESSION['providedFormData']);

    $next();
  }
}
