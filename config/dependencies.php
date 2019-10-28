<?php

use BestThor\ScrappingMaster\Application\Service\RetrieveElementService;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDownloadUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\SaveElementInFileUseCase;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();

$containerBuilder->setParameter(
    'torrentDir',
    __DIR__ . '/../scrap-torrent'
);

$containerBuilder->setParameter(
    'downloadElementTorrentUrl',
    '/uploads/torrents/peliculas/'
);

$containerBuilder->setParameter(
    'homeUrl',
    'http://www.mejortorrentt.org'
);

$containerBuilder->setParameter(
    'filmUrl',
    '/secciones.php?sec=descargas&ap=peliculas&p=%s'
);

$containerBuilder->setParameter(
    'downloadElementUrl',
    '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1'
);

$containerBuilder->register(
    ElementGeneralFactory::class,
    ElementGeneralFactory::class
);

$containerBuilder->register(
    ElementGeneralParser::class,
    ElementGeneralParser::class
)->addArgument(new Reference(ElementGeneralFactory::class));

$containerBuilder->register(
    RetrieveElementGeneralUseCase::class,
    RetrieveElementGeneralUseCase::class
)->addArgument(new Reference(ElementGeneralParser::class));

$containerBuilder->register(
    ElementDetailFactory::class,
    ElementDetailFactory::class
)->addArgument('%torrentDir%');

$containerBuilder->register(
    ElementDetailParser::class,
    ElementDetailParser::class
)->addArgument(new Reference(ElementDetailFactory::class));

$containerBuilder->register(
    RetrieveElementDetailUseCase::class,
    RetrieveElementDetailUseCase::class
)->addArgument(new Reference(ElementDetailParser::class));

$containerBuilder->register(
    ElementDownloadFactory::class,
    ElementDownloadFactory::class
)->addArgument('%downloadElementTorrentUrl%');

$containerBuilder->register(
    ElementDownloadParser::class,
    ElementDownloadParser::class
)->addArgument(new Reference(ElementDownloadFactory::class));

$containerBuilder->register(
    RetrieveElementDownloadUseCase::class,
    RetrieveElementDownloadUseCase::class
)->addArgument(new Reference(ElementDownloadParser::class));

$containerBuilder->register(
    GuzzleMTContentReaderRepository::class,
    GuzzleMTContentReaderRepository::class
)
    ->addArgument('%homeUrl%')
    ->addArgument('%filmUrl%')
    ->addArgument('%downloadElementUrl%');

$containerBuilder->register(
    SaveElementInFileUseCase::class,
    SaveElementInFileUseCase::class
)->addArgument(new Reference(GuzzleMTContentReaderRepository::class));

$containerBuilder->register(
    RetrieveElementService::class,
    RetrieveElementService::class
)
    ->addArgument(new Reference(RetrieveElementGeneralUseCase::class))
    ->addArgument(new Reference(RetrieveElementDetailUseCase::class))
    ->addArgument(new Reference(RetrieveElementDownloadUseCase::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(SaveElementInFileUseCase::class));

return $containerBuilder;
