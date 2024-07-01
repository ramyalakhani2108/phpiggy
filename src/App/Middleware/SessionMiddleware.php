<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use App\Exceptions\SessionExceptions;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {

        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionExceptions("Session already active");
        }

        if (headers_sent($filename, $line)) {
            throw new SessionExceptions("Headers already sent.Consider enabling output buffering. Data Outputed from {$filename} - line: {$line}");
        }   //if this condition is true than it means the data is already meant to be send
        session_start();
        $next();
        session_write_close(); //this function instrcuts php to wrrite the session data and close the session 
    }
}
