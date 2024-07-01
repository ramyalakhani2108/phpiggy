<?php

include __DIR__ . "/../src/App/functions.php";
$app = include __DIR__ . "/../src/App/bootstrap.php"; //here we are getting out app class instance ,completing registering routes and middleware initiated
$app->run();//uses the instance instantiated in bootstrap

// dd($app);

// sugar function
// it is a function for simplifying a few steps 
// typically a sugar function is a five lines of code 
