<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";  // automate include __DIR__ . "/../Framework/App.php";

use Framework\App;
use App\Config\Paths;
use Dotenv\Dotenv;

use function App\Config\{registerRoutes, registerMiddleware};

$app = new App(Paths::SOURCE . 'App/container-definitions.php');

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

registerRoutes($app);
registerMiddleware($app);

return $app;
