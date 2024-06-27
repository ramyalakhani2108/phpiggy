<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";


use Framework\App;
use function App\Config\registerRoutes; //we can import function using use function keyword
use App\Config\Paths;


$app = new App(Paths::SOURCE . "app/container-definitions.php");

registerRoutes($app);
// $app->get('about/team');


return $app;
