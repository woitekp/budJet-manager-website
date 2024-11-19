<?php

declare(strict_types=1);

namespace App\Config;

class Paths  // by using a class constants can be auto loaded with composer
{
  public const VIEW = __DIR__ . "/../views";
  public const SOURCE = __DIR__ . "/../../";
}
