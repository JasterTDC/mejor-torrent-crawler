<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Tag\GetTagUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\General\GetElementGeneralDetailController;
use BestThor\ScrappingMaster\Infrastructure\Controller\Tag\GetTagController;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Tag\GetTagDataTransformer;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\Series\AddSeriesTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\General\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\General\RetrieveElementGeneralCollectionController;
use BestThor\ScrappingMaster\Infrastructure\Controller\Series\RetrieveElementSeriesCollectionController;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDataTransformer;

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

$container->register(
    RetrieveElementGeneralCollectionController::class,
    RetrieveElementGeneralCollectionController::class
)
    ->addArgument(new Reference(RetrieveElementGeneralCollectionUseCase::class))
    ->addArgument(new Reference(ElementGeneralCollectionDataTransformer::class))
    ->addArgument(new Reference(TemplateRenderer::class));

$container->register(
    RetrieveElementSeriesCollectionController::class,
    RetrieveElementSeriesCollectionController::class
)
    ->addArgument(new Reference(RetrieveElementSeriesCollectionUseCase::class))
    ->addArgument(new Reference(ElementSeriesDataTransformer::class))
    ->addArgument(new Reference(TemplateRenderer::class));

$container->register(
    GetElementGeneralDetailController::class,
    GetElementGeneralDetailController::class
)
    ->addArgument(new Reference(GetElementGeneralDetailUseCase::class))
    ->addArgument(new Reference(TemplateRenderer::class))
    ->addArgument(new Reference(ElementGeneralDataTransformer::class));

$container->register(
    GetTagController::class,
    GetTagController::class
)
    ->addArgument(new Reference(GetTagUseCase::class))
    ->addArgument(new Reference(TemplateRenderer::class))
    ->addArgument(new Reference(GetTagDataTransformer::class));
