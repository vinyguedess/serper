<?php

require __DIR__ . '/../vendor/autoload.php';


use Silex\Application;


$app = new Application();

require __DIR__ . '/routes.php';

return $app;