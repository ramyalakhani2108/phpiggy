<?php

declare(strict_types=1);

namespace Framework\Contracts;

interface MiddlewareInterface
{
    public function process(callable $next); //it is for process the request we call it before the controller handles the request
}
