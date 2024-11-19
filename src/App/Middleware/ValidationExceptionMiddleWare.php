<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;


class ValidationExceptionMiddleware implements MiddlewareInterface
{
  public function process (callable $next)
  {
    try
    {
      $next();
    } catch (ValidationException $e)
    {
      $_SESSION['errors'] = $e->errors;

      $keysToExclude = array_flip(['password', 'confirmPassword']);  // convert values to keys
      $_SESSION['providedFormData'] = array_diff_key($_POST, $keysToExclude);  // exclude password fields from $_SESSION
      
      $referer = $_SERVER['HTTP_REFERER'];
      redirectTo($referer);
    }
  }
}
