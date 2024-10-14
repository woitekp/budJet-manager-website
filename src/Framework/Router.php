<?php

declare(strict_types=1);

namespace Framework;

class Router
{
  private array $routes = [];

  public function add(string $method, string $path) {
    $path = $this->normalizePath($path);

    $this->routes[] = [
      'method' => $method,
      'path' => strtoupper($path),
    ];
  }

  private function normalizePath(string $path) : string  {
    $path = trim($path, '/');
    $path = "/{$path}/";
    return preg_replace('#[/]{2,}#', '/', $path);
  }
}
