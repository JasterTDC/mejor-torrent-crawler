<?php

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

    $elementSeriesFinalCollection = [];

    /** @var ElementSeriesDetailParser $elementSeriesDetailParser */
    $elementSeriesDetailParser = $containerBuilder->get(ElementSeriesDetailParser::class);

    /** @var ElementSeriesDownloadParser $elementSeriesDownloadParser */
    $elementSeriesDownloadParser = $containerBuilder->get(ElementSeriesDownloadParser::class);

    foreach ($elementSeriesCollection as $elementSeries) {
        try {
            $content = $guzzleMT
                ->getElementSeriesDetailContent(
                    $elementSeries['link']
                );

            $elementSeriesDetailParser->setContent($content);

            $detail = $elementSeriesDetailParser->getElementDetail();

            if (!empty($detail)) {
                $elementSeries['imageUrl']  = $detail['imageUrl'];
                $elementSeries['imageName'] = $detail['imageName'];
                $elementSeries['description'] = $detail['description'];

                foreach ($detail['episodes'] as $singleDetail) {
                    $downloadContent = $guzzleMT
                        ->getElementSeriesDownloadContent($singleDetail['episodeId']);

                    $elementSeriesDownloadParser->setContent($downloadContent);

                    $download = $elementSeriesDownloadParser
                        ->getElementSeriesDownload();

                    if (!empty($download)) {
                        $singleDetail['download'] = [
                            'downloadLink' => $containerBuilder->getParameter('seriesDownloadTorrentUrl') .
                                $download['torrentName'],
                            'downloadName' => $download['torrentName']
                        ];
                    }

                    $elementSeries['detail'][] = $singleDetail;
                }
            }

            $elementSeriesFinalCollection[] = $elementSeries;
        } catch (\Exception $e) {
        }
    }

    file_put_contents(
        "/scrap/json/{$page}.json",
        json_encode($elementSeriesFinalCollection, true)
    );
}

if ('parse' === $method) {
    $elementSeriesCollection = json_decode(file_get_contents(
        "/scrap/json/{$page}.json"
    ), true);

    foreach ($elementSeriesCollection as $elementSeries) {
        $imageContent = $guzzleMT->getElementImageFile($elementSeries['imageUrl']);

        file_put_contents(
            "/static/img/{$elementSeries['firstId']}.jpg",
            $imageContent
        );

        $elementDir = "/scrap/torrent/" . $elementSeries['name'];

        if (!is_dir($elementDir)) {
            mkdir($elementDir);
        }

        if (!empty($elementSeries['detail'])) {
            foreach ($elementSeries['detail'] as $detail) {
                $torrent = $guzzleMT->getElementDownloadFile(
                    $detail['download']['downloadLink']
                );

                file_put_contents(
                    $elementDir . DIRECTORY_SEPARATOR . $detail['download']['downloadName'],
                    $torrent
                );
            }
        }
    }
}