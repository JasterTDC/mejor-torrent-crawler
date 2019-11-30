<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCaseArguments;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var ContainerBuilder $container */
$container = require_once __DIR__ . '/../slim-fw/dependencies.php';

$page = 1;

if (isset($argv[1]) && !empty($argv[1])) {
    $page = (int) $argv[1];
}

/** @var GetElementSeriesCollectionUseCase $useCase */
$useCase = $container->get(GetElementSeriesCollectionUseCase::class);

$useCaseResponse = $useCase(
    new GetElementSeriesCollectionUseCaseArguments(
        $page
    )
);
