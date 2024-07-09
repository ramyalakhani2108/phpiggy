<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};

class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {

        // $this->view = new TemplateEngine(Paths::VIEW); //this is we used to call the path before delepency injection
    }
    public function registerView()
    {
        // echo $this->view->render("register.php", ['errors' => $_SESSION['errors']]); // we can send error like this but its not recommanded way 
        // better way is to use middleware
        echo $this->view->render("register.php");
    }

    public function loginView()
    {
        echo $this->view->render("login.php");
    }

    // understanding services 
    // revising controller's idea 
    // controllers are responsible for business logic of a page 
    // but doing so controller becomes hundreads of line long 
    // most developer's doesn't agree it
    // to avoid this scenario 
    // there is a practice called 
    // skinny controller, fat services 
    // the idea behind this is controller are only responsible for receiving request and returning responses
    // everything else must be deligated to the service

    // what is a service ?
    // services are the classes for handling any type of operation 
    // it can range from validation to interacting with the database




    public function register()
    {
        $this->validatorService->validateRegister($_POST);
        $this->userService->isEmailTaken($_POST['email']);
        $this->userService->create($_POST);
        redirectTo('/');
    }

    public function login()
    {
        $this->validatorService->validateLogin($_POST);
        // $this->userService->isEmailTaken($_POST['email']);
        $this->userService->login($_POST);
        redirectTo("/");
    }

    public function logout()
    {
        $this->userService->logout();
        redirectTo("/");
    }
}
