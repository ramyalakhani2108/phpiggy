<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuthController, ErrorController, ProfileController, ReceiptController, TransactionController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};
use Error;

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
    $app->get('/transaction', [TransactionController::class, 'createView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction', [TransactionController::class, 'create'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}', [TransactionController::class, 'editView'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->post('/transaction/{transaction}', [TransactionController::class, 'edit'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->delete('/transaction/{transaction}', [TransactionController::class, 'delete'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->get('/transaction/{transaction}/reciept', [ReceiptController::class, 'uploadView'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->post('/transaction/{transaction}/reciept', [ReceiptController::class, 'upload'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->get('/transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'download'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->delete('/transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'delete'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->setErrorHnadler([ErrorController::class, 'notFound']);

    $app->get('/profile/{user}', [ProfileController::class, 'profileView'])->add(AuthRequiredMiddleware::class); //with params using ID 
    $app->post('/profile/{user}', [ProfileController::class, 'updateProfile'])->add(AuthRequiredMiddleware::class); //with params using ID 

} //it will register routes 
//using composer.json it will allow us to autoload this files 