<?php

declare(strict_types=1);
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
    http_response_code(302); //302 refers temporary redirect 
    exit;
}
