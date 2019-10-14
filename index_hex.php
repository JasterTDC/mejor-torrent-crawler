<?php

use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;

require_once __DIR__ . '/vendor/autoload.php';

$homeUrl = 'http://www.mejortorrentt.org';

$filmUrl = '/secciones.php?sec=descargas&ap=peliculas&p=%s';
$downloadElementUrl = '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1';
$downloadElementTorrentUrl = '/uploads/torrents/peliculas/';

$firstPage = sprintf(
    $homeUrl . $filmUrl,
    1
);

$html = file_get_contents($firstPage);

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
        $homeUrl . $downloadElementTorrentUrl
    );

    $retrieveElementGeneralUseCaseArgument = new RetrieveElementGeneralUseCaseArguments(
        empty($html) ? null : $html
    );
    $retrieveElementGeneralUseCaseResponse = $retrieveElementGeneralUseCase
        ->handle($retrieveElementGeneralUseCaseArgument);

    if (!$retrieveElementGeneralUseCaseResponse->isSuccess() &&
        empty($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection())) {
        echo $retrieveElementGeneralUseCaseResponse->getError() . "\n";

        exit(1);
    }

    /** @var ElementGeneral $elementGeneral */
    foreach ($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection() as $elementGeneral) {
        $elementDetailHtml = file_get_contents($homeUrl . $elementGeneral->getElementLink());

        $elementDownloadUrl = $homeUrl . sprintf(
                $downloadElementUrl,
                $elementGeneral->getElementId()
            );

        $retrieveElementDetailUseCaseArguments = new RetrieveElementDetailUseCaseArguments(
            empty($elementDetailHtml) ? null : $elementDetailHtml,
            $elementGeneral
        );
        $retrieveElementDetailUseCaseResponse = $retrieveElementDetailUseCase
            ->handle($retrieveElementDetailUseCaseArguments);

        $elementGeneral = $retrieveElementDetailUseCaseResponse
            ->getElementGeneral();

        $elementDownloadHtml = file_get_contents($elementDownloadUrl);

        if (!empty($elementDownloadHtml)) {
            $elementDownloadParser = new ElementDownloadParser(
                $elementDownloadFactory
            );
            $elementDownloadParser->setContent($elementDownloadHtml);

            $elementDownload = $elementDownloadParser->getElementDownload();
            $elementDownload = $elementDownload->setElementDownloadUrl(
                $elementDownloadUrl
            );

            $elementGeneral->setElementDownload($elementDownload);
        }
    }

    file_put_contents(
        __DIR__ . '/scrap-json/' . md5(time()),
        serialize($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection())
    );
} catch (\Exception $e) {
    echo "[Exception]...{$e->getMessage()}\n";

    exit(1);
}
