<?php

declare(strict_types=1);

use Framework\{Container, Database, TemplateEngine};
use App\Config\Paths;
use App\Services\{TransactionService, UserService, ValidatorService};

return [
  TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),  // alternatively anonymous function could be used instead of arrow function: function() {return new TemplateEngine(Paths::VIEW);}
  ValidatorService::class => fn() => new ValidatorService(),
  Database::class => fn() => new Database(
    $_ENV['DB_DRIVER'],
    [
      'host' => $_ENV['DB_HOST'],
      'port' => $_ENV['DB_PORT'],
      'dbname' => $_ENV['DB_NAME']
    ],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
  ),
  UserService::class => function (Container $container) {
    $db = $container->getDependency(Database::class);
    return new UserService($db);
  },
  TransactionService::class => function (Container $container) {
    $db = $container->getDependency(Database::class);
    return new TransactionService($db);
  }
];
