<?php

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesImageDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDetailDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDescriptionDataTransformer;

$container->register(
    ElementSeriesImageDataTransformer::class,
    ElementSeriesImageDataTransformer::class
);

$container->register(
    ElementSeriesDescriptionDataTransformer::class,
    ElementSeriesDescriptionDataTransformer::class
);

$container->register(
    ElementSeriesDownloadDataTransformer::class,
    ElementSeriesDownloadDataTransformer::class
);

$container->register(
    ElementSeriesDetailDataTransformer::class,
    ElementSeriesDetailDataTransformer::class
)
    ->addArgument(new Reference(ElementSeriesDownloadDataTransformer::class));

$container->register(
    ElementSeriesDataTransformer::class,
    ElementSeriesDataTransformer::class
)
    ->addArgument(new Reference(ElementSeriesImageDataTransformer::class))
    ->addArgument(new Reference(ElementSeriesDescriptionDataTransformer::class))
    ->addArgument(new Reference(ElementSeriesDetailDataTransformer::class));

$container->register(
    ElementGeneralCollectionDataTransformer::class,
    ElementGeneralCollectionDataTransformer::class
);
