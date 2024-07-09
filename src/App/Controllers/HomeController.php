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
use App\Services\TransactionService;



class HomeController
{

    public function __construct(private TemplateEngine $view, public TransactionService $transactionService)
    {

        // $this->view = new TemplateEngine(Paths::VIEW); //this is we used to call the path before delepency injection
    }
    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = (int) ($page - 1) * $length;
        [$transactions, $count] = $this->transactionService->getUserTransactions($length, $offset);
        $searchTerm = $_GET['s'] ?? '';
        $lastPage = ceil($count / $length);
        $pages = $lastPage ? range(1, $lastPage) : [];

        $pageLinks = array_map(
            fn ($pageNum) => http_build_query([
                'p' => $pageNum,
                's' => $searchTerm
            ]),
            $pages
        );




        echo $this->view->render(
            "index.php"
            // , [
            //     // 'title' => 'Home Page',
            // ]
            ,
            [
                'transactions' => $transactions,
                'currentPage' => $page,
                'previousPageQuery' => http_build_query([
                    'p' => $page - 1,
                    's' => $searchTerm
                ]),
                'lastPage' => $lastPage,
                'nextPageQuery' => http_build_query([
                    'p' => $page + 1,
                    's' => $searchTerm
                ]),
                'pageLinks' => $pageLinks,
                'searchTerm' => $searchTerm
            ]
        );
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