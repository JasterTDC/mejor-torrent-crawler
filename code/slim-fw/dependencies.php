<?php

use BestThor\ScrappingMaster\Application\Service\RetrieveElementService;
use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementDownload\RetrieveElementDownloadUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementInFileUseCase;
use BestThor\ScrappingMaster\Infrastructure\Controller\MainController;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();

$containerBuilder->setParameter(
    'torrentDir',
    '/scrap/torrent'
);

$containerBuilder->setParameter(
    'staticImgDir',
    '/static/img/'
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

$containerBuilder->setParameter(
    'PdoWriterDsn',
    'mysql:host=sql;charset=utf8;port=3306;database=elements'
);

$containerBuilder->setParameter(
    'PdoWriterUsername',
    'root'
);

$containerBuilder->setParameter(
    'PdoWriterPassword',
    'root'
);

$containerBuilder->setParameter(
    'PdoReaderDsn',
    'mysql:host=sql;charset=utf8;port=3306;database=elements'
);

$containerBuilder->setParameter(
    'PdoReaderUsername',
    'root'
);

$containerBuilder->setParameter(
    'PdoReaderPassword',
    'root'
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
)->addArgument('%torrentDir%');

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
    RetrieveElementGeneralUseCase::class,
    RetrieveElementGeneralUseCase::class
)->addArgument(new Reference(ElementGeneralParser::class));

$containerBuilder->register(
    ElementDetailParser::class,
    ElementDetailParser::class
)->addArgument(new Reference(ElementDetailFactory::class));

$containerBuilder->register(
    RetrieveElementDetailUseCase::class,
    RetrieveElementDetailUseCase::class
)->addArgument(new Reference(ElementDetailParser::class));

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
)
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument('%staticImgDir%');

$containerBuilder->register(
    PdoAccess::class,
    PdoAccess::class
)
    ->addArgument('%PdoWriterDsn%')
    ->addArgument('%PdoWriterUsername%')
    ->addArgument('%PdoWriterPassword%');

$containerBuilder->register(
    'PdoReader',
    PdoAccess::class
)
    ->addArgument('%PdoReaderDsn%')
    ->addArgument('%PdoReaderUsername%')
    ->addArgument('%PdoReaderPassword%');

$containerBuilder->register(
    MysqlPdoElementGeneralWriterRepository::class,
    MysqlPdoElementGeneralWriterRepository::class
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
    SaveElementGeneralUseCase::class,
    SaveElementGeneralUseCase::class
)->addArgument(new Reference(MysqlPdoElementGeneralWriterRepository::class));

$containerBuilder->register(
    RetrieveElementService::class,
    RetrieveElementService::class
)
    ->addArgument(new Reference(RetrieveElementGeneralUseCase::class))
    ->addArgument(new Reference(RetrieveElementDetailUseCase::class))
    ->addArgument(new Reference(RetrieveElementDownloadUseCase::class))
    ->addArgument(new Reference(GuzzleMTContentReaderRepository::class))
    ->addArgument(new Reference(SaveElementInFileUseCase::class))
    ->addArgument(new Reference(SaveElementGeneralUseCase::class));

$containerBuilder->register(
    MainController::class,
    MainController::class
)
    ->addArgument(new Reference(GetElementGeneralUseCase::class))
    ->addArgument(new Reference(TemplateRenderer::class));

return $containerBuilder;
