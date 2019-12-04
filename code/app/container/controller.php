<?php

use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\AddSeriesTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;

$container->register(
    MainController::class,
    MainController::class
)
    ->addArgument(new Reference(GetElementUseCase::class))
    ->addArgument(new Reference(ElementSeriesDataTransformer::class))
    ->addArgument(new Reference(TemplateRenderer::class));

$container->register(
    AddGeneralTorrentController::class,
    AddGeneralTorrentController::class
)
    ->addArgument(new Reference(AddGeneralTorrentUseCase::class));

$container->register(
    AddSeriesTorrentController::class,
    AddSeriesTorrentController::class
)->addArgument(new Reference(AddSeriesTorrentUseCase::class));
