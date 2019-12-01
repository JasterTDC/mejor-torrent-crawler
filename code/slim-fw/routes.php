<?php

use BestThor\ScrappingMaster\Infrastructure\Controller\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$application = AppFactory::create();

$application->group('/', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->get('', MainController::class)
        ->setName('main');
});

$application->group('/general', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->post('/add', AddGeneralTorrentController::class)
        ->setName('general-add');
});
