<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerException;


class Container
{
  private array $definitions = [];
  private array $resolved = [];

  public function resolve(string $className)
  {
    $reflectionClass = new ReflectionClass($className);

    if (!$reflectionClass->isInstantiable())
    {
      throw new ContainerException("Class {$className} is not instantiable");
    }

    $constructor = $reflectionClass->getConstructor();
    if (!$constructor)
    {
      return new $className;
    }

    $params = $constructor->getParameters();

    if (count($params) === 0)
    {
      return new $className;
    }

    $dependencies = [];

    foreach ($params as $param)
    {
      $name = $param->getName();
      $type = $param->getType();

      if (!$type)
      {
        throw new ContainerException("Failed to resolve {$className} - missing type hint for parameter: {$name}");
      }

      if (!$type instanceof ReflectionNamedType || $type->isBuiltin())
      {
        throw new ContainerException("Failed to resolve {$className} - invalid type for parameter: {$name}");
      }

      $dependencies[] = $this->getDependency($type->getName());
    }

    return $reflectionClass->newInstanceArgs($dependencies);
  }

  
  public function getDependency(string $className)
  {
    if (!array_key_exists($className, $this->definitions))
    {
      throw new ContainerException("Class {$className} does not exists in a container");
    }

    if (array_key_exists($className, $this->resolved))
    {
      return $this->resolved[$className];
    }

    $factory = $this->definitions[$className];
    $instance = $factory();

    $this->resolved[$className] = $instance;

    return $instance;
  }

  public function addDefinitions(array $newDefinitions)
  {
    $this->definitions = [...$this->definitions, ...$newDefinitions];  // spread operator is slighlty faster than array_merge()
  }
}
