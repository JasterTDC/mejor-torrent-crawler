<?php

use BestThor\ScrappingMaster\Infrastructure\Controller\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\AddSeriesTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\Controller\RetrieveElementGeneralCollectionController;
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

    $routeCollectorProxy
        ->get('/get/{page}', RetrieveElementGeneralCollectionController::class)
        ->setName('general-get');
});

$application->group('/series', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->post('/add', AddSeriesTorrentController::class)
        ->setName('series-add');
});
