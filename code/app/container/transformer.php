<?php

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Tag\GetTagDataTransformer;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesImageDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDetailDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDescriptionDataTransformer;

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

$container->register(
    ElementGeneralDataTransformer::class,
    ElementGeneralDataTransformer::class
);

$container->register(
    GetTagDataTransformer::class,
    GetTagDataTransformer::class
);
