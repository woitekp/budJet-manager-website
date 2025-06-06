<?php

declare(strict_types=1);

namespace Framework;

class Router
{
  private array $routes = [];
  private array $middlewares = [];
  private array $errorHandler = [];

  public function dispatch(string $path, string $method, Container $container = null)
  {
    $path = $this->normalizePath($path);
    $method = strtoupper($_POST['_METHOD'] ?? $method);

    foreach ($this->routes as $route) {
      if (!preg_match("#^{$route['regexPath']}$#", $path, $paramValues) || $route['method'] !== $method)  // ^, $ - value begins and ends (respectively) with the pattern
      {
        continue;
      }

      // first match is full path (e.g. 'expenses/1') which is not needed. With array_shift() first key of an arrays is removed
      array_shift($paramValues);

      preg_match_all('#{([^/]+)}#',  $route['path'], $paramKeys);

      $paramKeys = $paramKeys[1];

      $params = array_combine($paramKeys, $paramValues);

      [$class, $function] = $route['controller'];  // destructurization
      $controllerInstance = $container ? $container->resolve($class) : new $class;

      $action = fn() => $controllerInstance->{$function}($params);  // PHP attempts to resolve string value to a class method

      $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

      foreach ($allMiddleware as $middleware) {
        $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
        $action = fn() => $middlewareInstance->process($action);
      }

      $action();

      return;
    }

    $this->dispatchNotFound($container);
  }

  public function addRoute(string $method, string $path, array $controller)
  {
    $path = $this->normalizePath($path);

    $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

    $this->routes[] = [
      'method' => strtoupper($method),
      'path' => $path,
      'controller' => $controller,
      'middlewares' => [],
      'regexPath' => $regexPath
    ];
  }

  public function addMiddleware(string $middleware)
  {
    $this->middlewares[] = $middleware;
  }

  public function addRouteMiddleware(string $middleware)
  {
    $lastRouteKey = array_key_last($this->routes);
    $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
  }

  private function normalizePath(string $path): string
  {
    $path = trim($path, '/');
    $path = "/{$path}/";
    return preg_replace('#[/]{2,}#', '/', $path);
  }

  public function setErrorHandler(array $controller)
  {
    $this->errorHandler = $controller;
  }

  public function dispatchNotFound(?Container $container)
  {
    [$class, $function] = $this->errorHandler;

    $controllerInstance = $container ? $container->resolve($class) : new $class;

    $action = fn() => $controllerInstance->$function();

    foreach ($this->middlewares as $middleware) {
      $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
      $action = fn() => $middlewareInstance->process($action);
    }

    $action();
  }
}
