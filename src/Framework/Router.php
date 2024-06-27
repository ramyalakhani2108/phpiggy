<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalizePath($path); //sending the path entered by developer to normalized it
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
        ]; //this will create a multi dimentional array for storing routes 
        // print_r($this->routes);
    }

    public function normalizePath(string $path): string
    {


        // remainder : 
        // $path = trim($path, '/'); //remove the / character from beginning and at the end of the string 
        // print_r($path);
        // $path = "/{$path}/"; // adding a / at the beginning and the end of the string 
        // return $path; //returns the normalized path

        // this above code doesn't suitable for the pages like index page it will generate output like '//' so to tackel this we can use 
        // either conditional statements (it will limited) or
        // using regular expressions

        // regular expression: 
        // is a pattern which apply to the string to find matches 
        // it matches the string based on the pattern given 

        $path = trim($path, '/'); //remove the / character from beginning and at the end of the string 
        $path = "/{$path}/"; // adding a / at the beginning and the end of the string 
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path; //returns the normalized path

    }

    public function dispatch(string $path, string $method, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                // echo "#^{$route['path']}$#";
                continue;
            } //this condition will only executes when the path in routes or method matches exactly with dispach parameters  
            [$class, $function] = $route['controller']; //this will saperate class name and function 

            $controllerInstance = $container ? $container->resolve($class) :  new $class(); //completely acceptable to provide a string after the new keyword as long as the string points to the specific class with the namespace
            $controllerInstance->{$function}(); //allow to pass a string as a method name after the arrow 
        }
    }
}
