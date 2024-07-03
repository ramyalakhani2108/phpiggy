<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null) //by default it will be no for best practice 
    {
        $this->router = new Router(); //creating an instance of router class 
        $this->container = new Container(); //creating an instance of Container

        // container is just stop page making direct instances of class 




        if ($containerDefinitionsPath) {
            // dd($containerDefinitionsPath);// it contains the path of the container-definitions file
            $containerDefinitionsPath = include $containerDefinitionsPath; //it will include the container-definition file path which returns array 
            // dd($containerDefinitionsPath); // now this variable has an array with key as template engine class and value as VIEW constant which is a path of view folder
            // invokes the constructor with of the template engine class with the view folder's path

            $this->container->addDefinitions($containerDefinitionsPath); //it will add this path to the definition's array of container
        }
    }
    public function run()
    {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //making the small chunk of we needed like /,/about
        // echo "path: ", $path;
        $method = $_SERVER['REQUEST_METHOD']; //getting the method of request
        // echo "method: ", $method;

        $this->router->dispatch($path, $method, $this->container); //sending the path and method with container instance to act between the controller and route 
    }

    public function get(string $path, array $controller): App //accept the route name as path and array of data [contoller class and function name]
    {
        $this->router->add("GET", $path, $controller); //we are using get method instead of post because it is okay to show just a name of route for understanding

        return $this; //returning this keyword to return the object of app class to apply method(add) chaining for adding middlewares imedietly after route register
    } //this method will give route class to add routes to the array of routes

    public function addMiddleware(string $middleware)
    {
        $this->router->addMiddleware($middleware);
    }

    public function post(string $path, array $controller): App //accept the route name as path and array of data [contoller class and function name]
    {
        $this->router->add("POST", $path, $controller); //we are using get method instead of post because it is okay to show just a name of route for understanding
        return $this;
    }

    public function add(string $middleware)
    {
        $this->router->addRouteMiddleware($middleware);
    }
}
