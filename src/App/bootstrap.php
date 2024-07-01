<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";


use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware}; //we can import function using use function keyword
use App\Config\Paths;


$app = new App(Paths::SOURCE . "app/container-definitions.php");

//after executing first line we successfully rendered the pages and added definitions in container 



registerRoutes($app); //this method is used for register routes 
registerMiddleware($app); // it will use for registering middlewares



//here we are completed with the route and middleware we have successfully registered
// $app->get('about/team');


return $app; //return the app instance we have instantiated
