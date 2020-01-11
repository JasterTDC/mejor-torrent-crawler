<?php

use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;

$container->register(
    ElementDetailFactory::class,
    ElementDetailFactory::class
)->addArgument(getenv('TORRENT_DIR'));

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