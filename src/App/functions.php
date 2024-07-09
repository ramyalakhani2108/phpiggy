<?php

declare(strict_types=1);

use Framework\Http;

function dd(mixed $value) //short for dump and die
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
    die();
}

function e(mixed $value): string
{

    return htmlspecialchars((string)$value);
} //for escaping character


function redirectTo(string $path)
{
    header("Location: {$path}");
    http_response_code(Http::REDIRECT_STATUS_CODE); //302 refers temporary redirect 
    exit;
}
