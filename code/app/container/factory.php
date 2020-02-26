<?php

use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\GeneralTagFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;

$container->register(
    ElementDetailFactory::class,
    ElementDetailFactory::class
);

$container->register(
    ElementDownloadFactory::class,
    ElementDownloadFactory::class
)->addArgument('%downloadElementTorrentUrl%');

$container->register(
    ElementGeneralFactory::class,
    ElementGeneralFactory::class
)
    ->addArgument(new Reference(ElementDetailFactory::class))
    ->addArgument(new Reference(ElementDownloadFactory::class));

$container->register(
    ElementSeriesFactory::class,
    ElementSeriesFactory::class
);

$container->register(
    ElementSeriesImageFactory::class,
    ElementSeriesImageFactory::class
);

$container->register(
    ElementSeriesDetailFactory::class,
    ElementSeriesDetailFactory::class
);

$container->register(
    ElementSeriesDownloadFactory::class,
    ElementSeriesDownloadFactory::class
)->addArgument('%seriesDownloadTorrentUrl%');

$container->register(
    FromMysqlElementSeriesDescriptionFactory::class,
    FromMysqlElementSeriesDescriptionFactory::class
);

$container->register(
    FromMysqlElementSeriesImageFactory::class,
    FromMysqlElementSeriesImageFactory::class
);

$container->register(
    FromMysqlElementSeriesFactory::class,
    FromMysqlElementSeriesFactory::class
)
    ->addArgument(new Reference(FromMysqlElementSeriesImageFactory::class))
    ->addArgument(new Reference(FromMysqlElementSeriesDescriptionFactory::class));

$container->register(
    TagFactory::class,
    TagFactory::class
);

$container->register(
    GeneralTagFactory::class,
    GeneralTagFactory::class
);