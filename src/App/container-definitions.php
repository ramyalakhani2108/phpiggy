<?php
// in this file contain the definition 
// the job of the container is to store a list of instrcution for creating instances in programming world this known as 'definitions'

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;



// return [
//     TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW)
// ]; //this is our first facotry funcion

return [
    TemplateEngine::class => function () {
        return new TemplateEngine(Paths::VIEW);
    }
];
// we are going grab this array for that we need a property in a container for storing array of definitions


// facotory design pattern 
// what is it ? 
// A function that creates an instance of class 
// the idea of creating an instance from a function is known as the facotry design pattern 
// why ? 

// Not every class is needed to be instantiated 
// every page in our application is different 
// therefore it is possible for pages to have different dependencies if an instance of the class is unnecessary, there isn't a reson for that instance to exist 
// we can write a facotry function that will executed by the container when an instance of  class is requested
// it is used for adding definitions for the template engine class 

// the job of the cotnainer is to create instances of classes that can be made available to other classes 
// we will provide instruction using functions 


// After checking params from container class

// As we loop through the parameters, we're going to use Parameter type to check if a facotry function exist for that type
// if it does, we'll invoke the respective factory function which returns an instance of the same class
// the instance will then be passed on to the controller as it is instantiated