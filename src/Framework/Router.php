<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = []; //creating an empty array which stores the routes 
    private array $middlewares = []; //creating an empty array which stores middleware 

    public function add(string $method, string $path, array $controller) //accpeting three parameter method,routename and array of data[controller class namespace and its function to render]
    {
        $path = $this->normalizePath($path); //sending the path entered by developer to normalized it
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
        ]; //this will create a multi dimentional array for storing route requested
        // dd($this->routes);
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

    public function dispatch(string $path, string $method, Container $container = null) //accpets the three parameters route path, method and container class object 
    //the container is by default null because it will be good practice to use need container between route and controller for better structure 
    // so to make our framework eligible for teh developers who dont uuse container make work
    {
        $path = $this->normalizePath($path); //getting the normalized path with standard method

        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                // echo "#^{$route['path']}$#";
                continue;
            } //this condition will only executes when the path in routes or method dont matches exactly with dispach parameters  
            //basically above method is just finding the exact matching route from stored routes 

            [$class, $function] = $route['controller']; //this will saperate class name and function 

            $controllerInstance = $container ? $container->resolve($class) :  new $class(); //completely acceptable to provide a string after the new keyword as long as the string points to the specific class with the namespace
            //in this if we provide the container then it will go to that resolve method with the class name 

            $action = fn () => $controllerInstance->{$function}(); //allow to pass a string as a method name after the arrow 

            foreach ($this->middlewares as $middleware) {
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $action = fn () => $middlewareInstance->process($action);
            } //this will cause each middleware to execute in chain

            $action();
            return;
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
        // dd($this->middlewares);
    }
}
