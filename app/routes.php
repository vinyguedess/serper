<?php
/* @var $app Silex\Application */

$app->get('/', 'SERPer\Controllers\AppController::indexAction');
$app->get('/search', 'SERPer\Controllers\AppController::searchAction');