<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {

            $next();
        } catch (ValidationException $e) {
            // dd($e->errors);//getting errors from valdiation execption class
            $_SESSION['errors'] = $e->errors;
            $excludedKeys = ['password', 'confirmPassowrd'];
            $oldFormData = $_POST;

            $formattedFormData = array_diff_key($oldFormData, array_flip($excludedKeys));


            $_SESSION['oldFormData'] = $formattedFormData;

            $referer = $_SERVER['HTTP_REFERER'];
            //$_SERVER['HTTP_REFERER'] it is a special value available after the form submission stores the url after submission
            redirectTo("{$referer}");
        }
    }
}


//this technique of redirecting called prg 
//post redirect get  
