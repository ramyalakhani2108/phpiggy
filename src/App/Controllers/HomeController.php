<?php

//  This is where the MVC (Model view controller ) design patter starts
//  The key difference between design pattern and PSR is PSR is php oriented and design pattern is for all languages 
// in this MVC model refers to perform the database logics 
//  controller refers to the perform the page logic 
// view refers to how the data is presenting 
// in this framework 
// Router -> Controller -> Model -> (goes back to)Controller -> View -> (goes back to ) Controllers -> then render it to computer 

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController
{

    public function __construct(private TemplateEngine $view)
    {
        $this->view = new TemplateEngine(Paths::VIEW); //this is we used to call the path before delepency injection
    }
    public function home()
    {
        echo $this->view->render("index.php", [
            'title' => 'Home Page',
        ]);
        // echo " Home page ";
    }
}

// problem with the this solution 
// the class for rendering html must be accessible to all the controllers 


// the solution 
// Create a system to expose this class to all the controllers
// it is known as dependency injection 
// it is a system that does two things; create instances and pass them onto our classes (its not only for php {designpattern})

// we should create container for it 
// A container is is an object containing instruction for creating instance of classes 