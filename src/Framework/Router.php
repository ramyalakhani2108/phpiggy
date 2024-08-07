<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = []; //creating an empty array which stores the routes 

    private array $middlewares = []; //creating an empty array which stores middleware 
    private array $errorHandler = [];

    public function add(string $method, string $path, array $controller) //accpeting three parameter method,routename and array of data[controller class namespace and its function to render]
    {
        $path = $this->normalizePath($path); //sending the path entered by developer to normalized it

        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath //each route going to store its own middleware 
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

        $method = strtoupper($_POST['_METHOD'] ?? $method); //it check if the method have _method then it will assign it delete
        // dd($method);
        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['regexPath']}$#", $path, $paramValues) || //parameter is marked as refereces will create the variable which will then be accessible in our method 
                $route['method'] !== $method
            ) {
                // echo "#^{$route['path']}$#";
                continue;
            } //this condition will only executes when the path in routes or method dont matches exactly with dispach parameters  
            //basically above method is just finding the exact matching route from stored routes 

            array_shift($paramValues); //remove the entire path and it will take only that value which we need 

            preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys); //it will return all possible values 
            $paramKeys = $paramKeys[1];


            $params = array_combine($paramKeys, $paramValues); //making a key value pair of parameters [transaction]
            // dd($params);

            [$class, $function] = $route['controller']; //this will saperate class name and function 

            $controllerInstance = $container ? $container->resolve($class) :  new $class(); //completely acceptable to provide a string after the new keyword as long as the string points to the specific class with the namespace
            //in this if we provide the container then it will go to that resolve method with the class name 

            $action = fn () => $controllerInstance->{$function}($params); //allow to pass a string as a method name after the arrow 
            // $allMiddleware = [...$this->routes['middleware'], ...$this->middlewares]; //order matters
            //middleware registered last executed first middleware first and root middleware last 


            // dd($this->routes['middleware']);
            $allMiddleware = [...$route['middlewares'], ...$this->middlewares]; //order matters: global middlewares first, route-specific middlewares last
            // dd([...$route['middlewares'], ...$this->middlewares]);
            // from our framework, we are going to run global 
            foreach ($allMiddleware as $middleware) {
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $action = fn () => $middlewareInstance->process($action);
            } //this will cause each middleware to execute in chain

            $action();
            return;
        }

        $this->dipatchNotFound($container);
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
        // dd($this->middlewares);
    }

    public function addRouteMiddleware(string $middleware)
    {
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }

    public function setErrorHandler(array $controller)
    {
        $this->errorHandler = $controller;
    }
    public function dipatchNotFound(?Container $container)
    {
        [$class, $function] = $this->errorHandler;
        $controlllerInstance = $container ? $container->resolve($class) : new $class();

        $action = fn () => $controlllerInstance->$function();

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware();
            $action = fn () => $middlewareInstance->process($action);
        }
        $action();
    }
}
