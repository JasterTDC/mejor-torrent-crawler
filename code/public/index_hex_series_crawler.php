<?php

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesParser;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var ContainerBuilder $containerBuilder */
$containerBuilder = require_once __DIR__ . '/../slim-fw/dependencies.php';

/** @var GuzzleMTContentReaderRepository $guzzleMT */
$guzzleMT = $containerBuilder->get(GuzzleMTContentReaderRepository::class);

$page = 1;

$method = 'crawl';

if (!empty($argv[1])) {
    $page = (int) $argv[1];
}

if (!empty($argv[2])) {
    $method = $argv[2];
}

try {
    $content = $guzzleMT->getElementSeriesContent($page);
} catch (\Exception $e) {
    exit(1);
}

if (empty($content)) {
    exit(2);
}

if ('crawl' === $method) {
    /** @var ElementSeriesParser $elementSeriesParser */
    $elementSeriesParser = $containerBuilder->get(ElementSeriesParser::class);
    $elementSeriesParser->setContent($content);

    $elementSeriesCollection = $elementSeriesParser->getElementSeries();

    /** @var ElementSeriesDetailParser $elementSeriesDetailParser */
    $elementSeriesDetailParser = $containerBuilder->get(ElementSeriesDetailParser::class);

    /** @var ElementSeriesDownloadParser $elementSeriesDownloadParser */
    $elementSeriesDownloadParser = $containerBuilder->get(ElementSeriesDownloadParser::class);

    /** @var ElementSeries $elementSeries */
    foreach ($elementSeriesCollection as $elementSeries) {
        try {
            $content = $guzzleMT
                ->getElementSeriesDetailContent(
                    $elementSeries->getLink()
                );

            $elementSeriesDetailParser->setContent($content);

            $detailCollection = $elementSeriesDetailParser
                ->getElementDetail();
            $description = $elementSeriesDetailParser
                ->getElementSeriesDescription();
            $image = $elementSeriesDetailParser
                ->getElementSeriesImage();

            $elementDir = "/scrap/torrent/" . $elementSeries->getName();

            if (!is_dir($elementDir)) {
                mkdir($elementDir);
            }

            $elementSeriesDetailCollection = new ElementSeriesDetailCollection();

            /** @var ElementSeriesDetail $elementSeriesDetail */
            foreach ($detailCollection as $elementSeriesDetail) {
                $downloadContent = $guzzleMT
                    ->getElementSeriesDownloadContent(
                        $elementSeriesDetail->getId()
                    );

                $elementSeriesDownloadParser
                    ->setContent($downloadContent);

                $elementSeriesDetail = $elementSeriesDetail
                    ->setElementSeriesDownload(
                        $elementSeriesDownloadParser->getElementSeriesDownload()
                    );

                $downloadTorrentContent = $guzzleMT
                    ->getElementDownloadFile(
                        $elementSeriesDetail
                            ->getElementSeriesDownload()
                            ->getDownloadLink()
                    );

                file_put_contents(
                    $elementDir . DIRECTORY_SEPARATOR .
                    $elementSeriesDetail->getElementSeriesDownload()->getDownloadName(),
                    $downloadTorrentContent
                );

                $elementSeriesDetailCollection
                    ->add($elementSeriesDetail);
            }

            $elementSeries
                ->setElementSeriesImage($image);
            $elementSeries
                ->setElementSeriesDescription($description);
            $elementSeries
                ->setElementSeriesDetailCollection($elementSeriesDetailCollection);

            $imageContent = $guzzleMT
                ->getElementImageFile(
                    $elementSeries
                        ->getElementSeriesImage()
                        ->getImageUrl()
                );

            file_put_contents(
                "/static/img/{$elementSeries->getId()}.jpg",
                $imageContent
            );
        } catch (\Exception $e) {
        }
    }

    /** @var ElementSeriesDataTransformer $transformer */
    $transformer = $containerBuilder->get(ElementSeriesDataTransformer::class);

    file_put_contents(
        "/scrap/json/{$page}.json",
        json_encode(
            $transformer->transformCollection($elementSeriesCollection),
            true
        )
    );
}
