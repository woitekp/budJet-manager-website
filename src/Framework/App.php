<?php

declare(strict_types=1);

namespace Framework;

use Exception;

class App
{
  private Router $router;
  private Container $container;

  public function __construct(?string $containerDefinitionsPath = null)
  {
    $this->router = new Router();
    $this->container = new Container();

    if ($containerDefinitionsPath) {
      $containerDefinitions = include $containerDefinitionsPath;
      $this->container->addDefinitions($containerDefinitions);
    }
  }

  public function run()
  {
    try {
      $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $method = $_SERVER['REQUEST_METHOD'];
      $this->router->dispatch($path, $method, $this->container);
    } catch (Exception $e) {
      redirectTo('/error');
    }
  }

  public function get(string $path, array $controller): App
  {
    $this->router->addRoute('GET', $path, $controller);
    return $this;
  }

  public function post(string $path, array $controller): App
  {
    $this->router->addRoute('POST', $path, $controller);
    return $this;
  }

  public function delete(string $path, array $controller): App
  {
    $this->router->addRoute('DELETE', $path, $controller);
    return $this;
  }

  public function addMiddleware(string $middleware)
  {
    $this->router->addMiddleware($middleware);
  }

  public function addRouteMiddleware(string $middleware)
  {
    $this->router->addRouteMiddleware($middleware);
  }

  public function setErrorHandler(array $controller)
  {
    $this->router->setErrorHandler($controller);
  }
}
