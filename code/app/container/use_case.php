<?php

use Symfony\Component\DependencyInjection\Reference;
use BestThor\ScrappingMaster\Infrastructure\Service\SeriesService;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Infrastructure\Service\GeneralService;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesDetailWriterRepository;

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
