<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Notification\SendNotificationUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Tag\GetTagUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\GeneralTagFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\General\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\General\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesDetailWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Tag\MysqlPdoElementGeneralTagWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Tag\MysqlPdoTagReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Tag\MysqlPdoTagWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Service\GeneralService;
use BestThor\ScrappingMaster\Infrastructure\Service\SeriesService;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use Symfony\Component\DependencyInjection\Reference;

$container->register(
    GetElementGeneralUseCase::class,
    GetElementGeneralUseCase::class
)
    ->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class));

$container->register(
    GetElementSeriesCollectionUseCase::class,
    GetElementSeriesCollectionUseCase::class
)
    ->addArgument(new Reference(SeriesService::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesWriterRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesDetailWriterRepository::class))
    ->addArgument(getenv('TORRENT_SERIES_DIR'))
    ->addArgument(getenv('STATIC_IMG_DIR'));

$container->register(
    GetElementGeneralCollectionUseCase::class,
    GetElementGeneralCollectionUseCase::class
)
    ->addArgument(new Reference(GeneralService::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementGeneralWriterRepository::class))
    ->addArgument(new Reference(MysqlPdoTagReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoTagWriterRepository::class))
    ->addArgument(new Reference(MysqlPdoElementGeneralTagWriterRepository::class))
    ->addArgument(new Reference(GeneralTagFactory::class))
    ->addArgument(new Reference(TagFactory::class))
    ->addArgument(getenv('STATIC_IMG_DIR'))
    ->addArgument(getenv('TORRENT_FILM_DIR'));

$container->register(
    GetElementUseCase::class,
    GetElementUseCase::class
)
    ->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesReaderRepository::class));

$container->register(
    AddGeneralTorrentUseCase::class,
    AddGeneralTorrentUseCase::class
)
    ->addArgument(new Reference(TransmissionClient::class))
    ->addArgument(getenv('TORRENT_FILM_DIR'));

$container->register(
    AddSeriesTorrentUseCase::class,
    AddSeriesTorrentUseCase::class
)
    ->addArgument(getenv('TORRENT_SERIES_DIR'))
    ->addArgument(new Reference(TransmissionClient::class));

$container->register(
    RetrieveElementGeneralCollectionUseCase::class,
    RetrieveElementGeneralCollectionUseCase::class
)->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class));

$container->register(
    RetrieveElementSeriesCollectionUseCase::class,
    RetrieveElementSeriesCollectionUseCase::class
)->addArgument(new Reference(MysqlPdoElementSeriesReaderRepository::class));

$container->register(
    GetElementGeneralDetailUseCase::class,
    GetElementGeneralDetailUseCase::class
)->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class));

$container->register(
    GetTagUseCase::class,
    GetTagUseCase::class
)
    ->addArgument(new Reference(MysqlPdoTagReaderRepository::class));
