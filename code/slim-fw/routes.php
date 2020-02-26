<?php

use BestThor\ScrappingMaster\Infrastructure\Controller\General\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\Series\AddSeriesTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\General\GetElementGeneralDetailController;
use BestThor\ScrappingMaster\Infrastructure\Controller\Tag\GetTagController;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\Controller\General\RetrieveElementGeneralCollectionController;
use BestThor\ScrappingMaster\Infrastructure\Controller\Series\RetrieveElementSeriesCollectionController;
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

    $routeCollectorProxy
        ->get('/detail/{id}', GetElementGeneralDetailController::class)
        ->setName('general-detail');
});

$application->group('/series', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->post('/add', AddSeriesTorrentController::class)
        ->setName('series-add');

    $routeCollectorProxy
        ->get('/get/{page}', RetrieveElementSeriesCollectionController::class)
        ->setName('series-get');
});

$application->group('/tags', function(RouteCollectorProxy $routeCollectorProxy) {
    $routeCollectorProxy
        ->get('', GetTagController::class)
        ->setName('general-tags');
});
