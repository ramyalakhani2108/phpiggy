<?php

echo "<pre>";
print_r($_SERVER);
echo "</pre>";
$app = include __DIR__ . "/../src/App/bootstrap.php"; //here we are getting out app class instance 

$app->run();

