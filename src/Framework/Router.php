<?php

declare(strict_types=1);

namespace Framework;

class Router
{
  private array $routes = [];
  private array $middlewares = [];

  public function dispatch(string $path, string $method, Container $container = null)
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
      $controllerInstance = $container ? $container->resolve($class) : new $class;
      
      $action = fn() => $controllerInstance->{$function}();  // PHP attempts to resolve string value to a class method

      foreach($this->middlewares as $middleware)
      {
        $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
        $action = fn() => $middlewareInstance->process($action);
      }

      $action();
    }
  }

  public function addRoute(string $method, string $path, array $controller)
  {
    $path = $this->normalizePath($path);

    $this->routes[] = [
      'method' => strtoupper($method),
      'path' => $path,
      'controller' => $controller
    ];
  }

  public function addMiddleware(string $middleware)
  {
    $this->middlewares[] = $middleware;
  }

  private function normalizePath(string $path) : string 
  {
    $path = trim($path, '/');
    $path = "/{$path}/";
    return preg_replace('#[/]{2,}#', '/', $path);
  }

}
