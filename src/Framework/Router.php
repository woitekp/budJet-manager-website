<?php

declare(strict_types=1);

namespace Framework;

class Router
{
  private array $routes = [];

  public function add(string $method, string $path, array $controller)
  {
    $path = $this->normalizePath($path);

    $this->routes[] = [
      'method' => strtoupper($method),
      'path' => $path,
      'controller' => $controller
    ];
  }

  private function normalizePath(string $path) : string 
  {
    $path = trim($path, '/');
    $path = "/{$path}/";
    return preg_replace('#[/]{2,}#', '/', $path);
  }

  public function dispatch(string $path, string $method)
  {
    $path = $this->normalizePath($path);
    $method = strtoupper($method);

    foreach($this->routes as $route)
    {
      if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method)  // ^, $ - value begins and ends (respectively) with the pattern
      {  
        continue;
      }

      [$class, $function] = $route['controller'];  // destructurization
      $controllerInstance = new $class;
      $controllerInstance->$function();  // PHP attempts to resolve string value to a class method
    }

  }
}
