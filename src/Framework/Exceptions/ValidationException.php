<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException; //this class extends the exception class 

// what is the runtime category ?
// this category is meant for erros that will only occurs while the applicatition is running.
// It's meant for code that doesn't have to be fixed, but handled.



class ValidationException extends RuntimeException
{
    public function __construct(public array $errors, int $code = 422)
    {
        parent::__construct(code: $code);
    }
}
