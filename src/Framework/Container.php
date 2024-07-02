<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\ContainerExceptions;
use ReflectionClass, ReflectionNamedType;
use Framework\TemplateEngine;


class Container
{
    private array $definitions = []; //creating an empty array to register all the definitions 
    private array $resolved = [];

    public function addDefinitions(array $newDefinitions)
    {

        $this->definitions = [...$this->definitions, ...$newDefinitions]; //merging array 
    } //get an array with key as TemplateEngine class and key as the view folder path 
    //adding data to the array we created for this class to store definitions 
    // it will create multidimentional (assciative ) array 


    public function resolve(string $className) //it only provide us the controller name 
    // Now that we know what class to instantiate, we can look at its dependencies with reflective programming
    {
        $reflectionClass = new ReflectionClass($className); //created reflaction class instance with the classname provided above  

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerExceptions("Class {$className} is not instantiable ");
        } //checking if the class can have object or not 

        $constructor = $reflectionClass->getConstructor(); //it will check that the class have constructor or not
        // if the class have no constructor there are no dependencies there 
        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters(); //it will return array of parameter the class has

        if (count($params) === 0) {
            return new $className;
        } //if tehre is no element in array means there is no parameters than there is no dependencies so return new object


        $dependencies = []; //it will store the instances or dependencies required by our controller 

        // validating parameters 
        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerExceptions("Failed to resolve class {$className} because param {$name} is missing a typehint.");
            } //it check for available types like object or it will return null (it uses first typehinting)
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                //when there is only one typehint it will return ReflectionNamedType
                //when there is union types parameters it will return ReflectionUnionTypes
                // when parameters are with intersection it will return ReflectionIntersection type 

                // isBuiltin() is used to check if the types are using php's builtin datatypes
                throw new ContainerExceptions("Failed to resolve {$className} because invalid param name.");
            }
            $dependencies[] = $this->get($type->getName()); //it needs id so we are passing name along with the get method
        }
        // dd($dependencies);
        return $reflectionClass->newInstanceArgs($dependencies); //it create new instances and we are returning it 
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {

            throw new ContainerExceptions("Class {$id} doesn't exist in the container.");
        } //validating id and checking the isn't a dependency with this id
        $factory = $this->definitions[$id];
        // dd($this->definitions[TemplateEngine::class]());

        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }
        $dependency = $factory();
        $this->resolved[$id] = $dependency;

        //purpose of this resolve when we create instances it will given one id and each id will different for every instances 
        // so for stopping it we use resove so our variable become accessible globally
        return $dependency;
    }
}


// What are a class's dependencies?
// We must be able to peek inside a class to know what it wants with class name

// reflective programming is ablility for a program to look at it. php have a class for it called 'Reflection' 