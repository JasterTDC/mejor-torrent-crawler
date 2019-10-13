<?php

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementGeneralParser;

require_once __DIR__ . '/vendor/autoload.php';

$homeUrl = 'http://www.mejortorrentt.org';

$filmUrl = '/secciones.php?sec=descargas&ap=peliculas&p=%s';

$firstPage = sprintf(
    $homeUrl . $filmUrl,
    1
);

$html = file_get_contents($firstPage);

if (empty($html)) {
    echo "[HTML]...We could not retrieve main information\n";

    exit(1);
}

try {
    $dataTransformer = new ElementGeneralCollectionDataTransformer();
    $elementGeneralFactory = new ElementGeneralFactory();
    $elementGeneralParser = new ElementGeneralParser(
        $elementGeneralFactory
    );
    $elementDetailFactory = new ElementDetailFactory(
        __DIR__ . '/scrap-torrent'
    );

    $elementGeneralParser->setContent($html);

    $elementGeneralCollection = $elementGeneralParser->getElementGeneral();

    /** @var ElementGeneral $elementGeneral */
    foreach ($elementGeneralCollection as $elementGeneral) {
        $html = file_get_contents($homeUrl . $elementGeneral->getElementLink());

        if (!empty($html)) {
            $elementDetailParser = new ElementDetailParser(
                $elementDetailFactory
            );

            $elementDetailParser->setContent($html);

            $elementDetail = $elementDetailParser->getElementDetail();

            $elementGeneral->setElementDetail($elementDetail);
        }

        var_dump($elementGeneral);
    }
} catch (\Exception $e) {
    echo "[Exception]...{$e->getMessage()}\n";

    exit(1);
}
