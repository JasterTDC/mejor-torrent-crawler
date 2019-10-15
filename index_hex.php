<?php

use BestThor\ScrappingMaster\Application\Service\RetrieveElementService;
use BestThor\ScrappingMaster\Application\Service\RetrieveElementServiceArguments;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDownloadUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\SaveElementInFileUseCase;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;

require_once __DIR__ . '/vendor/autoload.php';

$homeUrl = 'http://www.mejortorrentt.org';

$filmUrl = '/secciones.php?sec=descargas&ap=peliculas&p=%s';
$downloadElementUrl = '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1';
$downloadElementTorrentUrl = '/uploads/torrents/peliculas/';

try {

    // Element general
    $elementGeneralFactory = new ElementGeneralFactory();
    $elementGeneralParser = new ElementGeneralParser(
        $elementGeneralFactory
    );
    $retrieveElementGeneralUseCase = new RetrieveElementGeneralUseCase(
        $elementGeneralParser
    );

    // Element detail
    $elementDetailFactory = new ElementDetailFactory(
        __DIR__ . '/scrap-torrent'
    );
    $elementDetailParser = new ElementDetailParser(
        $elementDetailFactory
    );
    $retrieveElementDetailUseCase = new RetrieveElementDetailUseCase(
        $elementDetailParser
    );

    // Element download
    $elementDownloadFactory = new ElementDownloadFactory(
        $downloadElementTorrentUrl
    );
    $elementDownloadParser = new ElementDownloadParser(
        $elementDownloadFactory
    );
    $retrieveElementDownloadUseCase = new RetrieveElementDownloadUseCase(
        $elementDownloadParser
    );

    $guzzleMTContentReaderRepository = new GuzzleMTContentReaderRepository(
        $homeUrl,
        $filmUrl,
        $downloadElementUrl
    );

    $saveElementInFileUseCase = new SaveElementInFileUseCase(
        $guzzleMTContentReaderRepository
    );

    $retrieveElementService = new RetrieveElementService(
        $retrieveElementGeneralUseCase,
        $retrieveElementDetailUseCase,
        $retrieveElementDownloadUseCase,
        $guzzleMTContentReaderRepository,
        $saveElementInFileUseCase
    );

    $retrieveElementServiceResponse = $retrieveElementService
        ->handle(
            new RetrieveElementServiceArguments(
                1
            )
        );

    if (!$retrieveElementServiceResponse->isSuccess()) {
        echo $retrieveElementServiceResponse->getError() . "\n";

        exit(1);
    }

    $elementGeneralCollection = $retrieveElementServiceResponse
        ->getElementGeneralCollection();

    $dataTransformer = new ElementGeneralCollectionDataTransformer();

    $elementGeneralCollectionTransformed = $dataTransformer
        ->transform(
            $elementGeneralCollection
        );

    file_put_contents(
        __DIR__ . '/scrap-json/' . md5(time()) . '.json',
        json_encode($elementGeneralCollectionTransformed,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        )
    );
} catch (\Exception $e) {
    echo "[Exception]...{$e->getMessage()}\n";

    exit(1);
}
