<?php

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\GetElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Infrastructure\Command\GeneralCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Command\SeriesCrawlerCommand;
use BestThor\ScrappingMaster\Infrastructure\Controller\AddGeneralTorrentController;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDescriptionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDetailDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesImageDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesParser;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesDetailWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Infrastructure\Service\GeneralService;
use BestThor\ScrappingMaster\Infrastructure\Service\SeriesService;
use BestThor\ScrappingMaster\Infrastructure\Transmission\TransmissionClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();

$writerHost = getenv('DB_ELEMENT_WRITER_HOSTNAME');
$writerPort = getenv('DB_ELEMENT_WRITER_PORT');
$writerDatabase = getenv('DB_ELEMENT_WRITER_DATABASE');

$readerHost = getenv('DB_ELEMENT_READER_HOSTNAME');
$readerPort = getenv('DB_ELEMENT_READER_PORT');
$readerDatabase = getenv('DB_ELEMENT_READER_DATABASE');

$pdoWriterDsn = "mysql:host={$writerHost};charset=utf8;port={$writerPort};database={$writerDatabase}";
$pdoReaderDsn = "mysql:host={$readerHost};charset=utf8;port={$readerPort};database={$writerDatabase}";

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
    'seriesUrl',
    '/secciones.php?sec=descargas&ap=series&p=%s'
);

$containerBuilder->setParameter(
    'seriesDownloadUrl',
    '/secciones.php?sec=descargas&ap=contar&tabla=series&id=%s'
);

$containerBuilder->setParameter(
    'seriesDownloadTorrentUrl',
    '/uploads/torrents/series/'
);

$containerBuilder->setParameter(
    'downloadElementUrl',
    '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1'
);

$containerBuilder->setParameter(
    'TemplateDir',
    __DIR__ . '/../views'
);

$containerBuilder->setParameter(
    'TemplateOptions',
    [
        'cache' => false
    ]
);

$containerBuilder->register(
    ElementDetailFactory::class,
    ElementDetailFactory::class
)->addArgument(getenv('TORRENT_DIR'));

$containerBuilder->register(
    ElementDownloadFactory::class,
    ElementDownloadFactory::class
)->addArgument('%downloadElementTorrentUrl%');

$containerBuilder->register(
    ElementGeneralFactory::class,
    ElementGeneralFactory::class
)
    ->addArgument(new Reference(ElementDetailFactory::class))
    ->addArgument(new Reference(ElementDownloadFactory::class));

$containerBuilder->register(
    ElementGeneralParser::class,
    ElementGeneralParser::class
)->addArgument(new Reference(ElementGeneralFactory::class));

$containerBuilder->register(
    ElementDetailParser::class,
    ElementDetailParser::class
)->addArgument(new Reference(ElementDetailFactory::class));

$containerBuilder->register(
    ElementSeriesFactory::class,
    ElementSeriesFactory::class
);

$containerBuilder->register(
    ElementSeriesParser::class,
    ElementSeriesParser::class
)
    ->addArgument(new Reference(ElementSeriesFactory::class));

$containerBuilder->register(
    ElementSeriesImageFactory::class,
    ElementSeriesImageFactory::class
);

$containerBuilder->register(
    ElementSeriesDetailFactory::class,
    ElementSeriesDetailFactory::class
);

$containerBuilder->register(
    ElementSeriesDetailParser::class,
    ElementSeriesDetailParser::class
)
    ->addArgument(new Reference(ElementSeriesImageFactory::class))
    ->addArgument(new Reference(ElementSeriesDetailFactory::class));

$containerBuilder->register(
    ElementSeriesDownloadFactory::class,
    ElementSeriesDownloadFactory::class
)
    ->addArgument('%seriesDownloadTorrentUrl%');

$containerBuilder->register(
    ElementSeriesDownloadParser::class,
    ElementSeriesDownloadParser::class
)
    ->addArgument(new Reference(ElementSeriesDownloadFactory::class));

$containerBuilder->register(
    ElementDownloadParser::class,
    ElementDownloadParser::class
)->addArgument(new Reference(ElementDownloadFactory::class));

$containerBuilder->register(
    GuzzleMTContentReaderRepository::class,
    GuzzleMTContentReaderRepository::class
)
    ->addArgument('%homeUrl%')
    ->addArgument('%filmUrl%')
    ->addArgument('%seriesUrl%')
    ->addArgument('%downloadElementUrl%')
    ->addArgument('%seriesDownloadUrl%');

$containerBuilder->register(
    PdoAccess::class,
    PdoAccess::class
)
    ->addArgument($pdoWriterDsn)
    ->addArgument(getenv('DB_ELEMENT_WRITER_USERNAME'))
    ->addArgument(getenv('DB_ELEMENT_WRITER_PASSWORD'));

$containerBuilder->register(
    'PdoReader',
    PdoAccess::class
)
    ->addArgument($pdoReaderDsn)
    ->addArgument(getenv('DB_ELEMENT_READER_USERNAME'))
    ->addArgument(getenv('DB_ELEMENT_READER_PASSWORD'));

$containerBuilder->register(
    MysqlPdoElementGeneralWriterRepository::class,
    MysqlPdoElementGeneralWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$containerBuilder->register(
    MysqlPdoElementSeriesWriterRepository::class,
    MysqlPdoElementSeriesWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$containerBuilder->register(
    MysqlPdoElementSeriesDetailWriterRepository::class,
    MysqlPdoElementSeriesDetailWriterRepository::class
)->addArgument(new Reference(PdoAccess::class));

$containerBuilder->register(
    MysqlPdoElementGeneralReaderRepository::class,
    MysqlPdoElementGeneralReaderRepository::class
)
    ->addArgument(new Reference('PdoReader'))
    ->addArgument(new Reference(ElementGeneralFactory::class));

$containerBuilder->register(
    GetElementGeneralUseCase::class,
    GetElementGeneralUseCase::class
)
    ->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class));

$containerBuilder->register(
    TemplateRenderer::class,
    TemplateRenderer::class
)
    ->addArgument('%TemplateDir%')
    ->addArgument('%TemplateOptions%');

$containerBuilder->register(
    ElementSeriesImageDataTransformer::class,
    ElementSeriesImageDataTransformer::class
);

$containerBuilder->register(
    ElementSeriesDescriptionDataTransformer::class,
    ElementSeriesDescriptionDataTransformer::class
);

$containerBuilder->register(
    ElementSeriesDownloadDataTransformer::class,
    ElementSeriesDownloadDataTransformer::class
);

$containerBuilder->register(
    ElementSeriesDetailDataTransformer::class,
    ElementSeriesDetailDataTransformer::class
)
    ->addArgument(new Reference(ElementSeriesDownloadDataTransformer::class));

$containerBuilder->register(
    ElementSeriesDataTransformer::class,
    ElementSeriesDataTransformer::class
)
    ->addArgument(new Reference(ElementSeriesImageDataTransformer::class))
    ->addArgument(new Reference(ElementSeriesDescriptionDataTransformer::class))
    ->addArgument(new Reference(ElementSeriesDetailDataTransformer::class));

$containerBuilder->register(
    MainController::class,
    MainController::class
)
    ->addArgument(new Reference(GetElementUseCase::class))
    ->addArgument(new Reference(ElementSeriesDataTransformer::class))
    ->addArgument(new Reference(TemplateRenderer::class));

$containerBuilder->register(
    AddGeneralTorrentController::class,
    AddGeneralTorrentController::class
)
    ->addArgument(new Reference(AddGeneralTorrentUseCase::class));

$containerBuilder->register(
    SeriesService::class,
    SeriesService::class
)
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(ElementSeriesParser::class))
    ->addArgument(new Reference(ElementSeriesDetailParser::class))
    ->addArgument(new Reference(ElementSeriesDownloadParser::class));

$containerBuilder->register(
    GeneralService::class,
    GeneralService::class
)
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(ElementGeneralParser::class))
    ->addArgument(new Reference(ElementDetailParser::class))
    ->addArgument(new Reference(ElementDownloadParser::class))
;

$containerBuilder->register(
    GetElementSeriesCollectionUseCase::class,
    GetElementSeriesCollectionUseCase::class
)
    ->addArgument(new Reference(SeriesService::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesWriterRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesDetailWriterRepository::class))
    ->addArgument(getenv('TORRENT_SERIES_DIR'))
    ->addArgument(getenv('STATIC_IMG_DIR'));

$containerBuilder->register(
    GetElementGeneralCollectionUseCase::class,
    GetElementGeneralCollectionUseCase::class
)
    ->addArgument(new Reference(GeneralService::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementGeneralWriterRepository::class))
    ->addArgument(getenv('STATIC_IMG_DIR'))
    ->addArgument(getenv('TORRENT_FILM_DIR'));

$containerBuilder->register(
    SeriesCrawlerCommand::class,
    SeriesCrawlerCommand::class
)->addArgument(new Reference(GetElementSeriesCollectionUseCase::class));

$containerBuilder->register(
    GeneralCrawlerCommand::class,
    GeneralCrawlerCommand::class
)->addArgument(new Reference(GetElementGeneralCollectionUseCase::class));

$containerBuilder->register(
    FromMysqlElementSeriesDescriptionFactory::class,
    FromMysqlElementSeriesDescriptionFactory::class
);

$containerBuilder->register(
    FromMysqlElementSeriesImageFactory::class,
    FromMysqlElementSeriesImageFactory::class
);

$containerBuilder->register(
    FromMysqlElementSeriesFactory::class,
    FromMysqlElementSeriesFactory::class
)
    ->addArgument(new Reference(FromMysqlElementSeriesImageFactory::class))
    ->addArgument(new Reference(FromMysqlElementSeriesDescriptionFactory::class));

$containerBuilder->register(
    MysqlPdoElementSeriesReaderRepository::class,
    MysqlPdoElementSeriesReaderRepository::class
)
    ->addArgument(new Reference(FromMysqlElementSeriesFactory::class))
    ->addArgument(new Reference('PdoReader'));

$containerBuilder->register(
    GetElementUseCase::class,
    GetElementUseCase::class
)
    ->addArgument(new Reference(MysqlPdoElementGeneralReaderRepository::class))
    ->addArgument(new Reference(MysqlPdoElementSeriesReaderRepository::class));

$containerBuilder->register(
    AddGeneralTorrentUseCase::class,
    AddGeneralTorrentUseCase::class
)
    ->addArgument(new Reference(TransmissionClient::class))
    ->addArgument(getenv('TORRENT_FILM_DIR'));

$containerBuilder->register(
    TransmissionClient::class,
    TransmissionClient::class
)
    ->addArgument(getenv('TRANSMISSION_HOSTNAME'))
    ->addArgument(getenv('TRANSMISSION_PORT'))
    ->addArgument(getenv('TRANSMISSION_USERNAME'))
    ->addArgument(getenv('TRANSMISSION_PASSWORD'));

return $containerBuilder;
