<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuthController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app) //it will accpet app class instance for registering new routes
{
    $app->get('/', [HomeController::class, 'home'])->add(AuthRequiredMiddleware::class); //give data to App.php file to store this route


    $app->get('/about', [AboutController::class, 'about']); //give data to App.php file to store this route
    // first parameter is the path or route name  of the class and second parameter as the array of details about the controller for render the data 

    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class);

    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class);
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);


    $app->get('/logout', [AuthController::class, 'logout'])->add(AuthRequiredMiddleware::class);
} //it will register routes 
//using composer.json it will allow us to autoload this files 