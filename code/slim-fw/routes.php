<?php

use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$application = AppFactory::create();

$application->group('/', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->get('', MainController::class)
        ->setName('main');
});
