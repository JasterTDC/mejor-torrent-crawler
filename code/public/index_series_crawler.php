<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

require_once __DIR__ . '/../vendor/autoload.php';

$baseUrl    = 'http://www.mejortorrentt.org/';
$seriesPage = 'secciones.php?sec=descargas&ap=series&p=%s';
$download   = 'secciones.php?sec=descargas&ap=contar&tabla=series&id=%s';
$downloadTorrent = 'uploads/torrents/series/';

function getSeriesLink(
    string $baseUrl,
    string $seriesPage,
    int $page
) : bool {
    try {
        $client = new GuzzleHttp\Client();

        $content = '';

        $response = $client->get(
            $baseUrl . sprintf($seriesPage, $page)
        );

        $content = (string) $response->getBody();
    } catch (ClientException $e) {
        print_r($e->getMessage());
    }

    if (empty($content)) {
        echo '[Content] We could not extract content from source';

        return false;
    }

    $domDocument = new \DOMDocument();
    $domDocument->loadHTML(
        $content,
        LIBXML_NOERROR
    );

    $domXPath = new \DOMXPath($domDocument);

    $linkNodeList = $domXPath->query('//a');

    if (empty($linkNodeList) &&
        (0 === $linkNodeList->length)
    ) {
        echo '[Parser] We could not find any series';

        return false;
    }

    $contentLinkArr['series'] = [];

    for ($i = 0; $i < $linkNodeList->count(); $i++) {
        $href = $linkNodeList->item($i)->attributes->getNamedItem('href')->nodeValue;

        if (preg_match(
            '/\/serie\-descargar\-torrents\-(?<elementFirstId>\d+)\-(?<elementSecondId>\d+)\-(?<elementName>.*)\.html$/',
            $href,
            $match
        )) {
            $contentLinkArr['series'][] = $href;
        }
    }

    if (!empty($contentLinkArr)) {
        file_put_contents(
            '/scrap/json/series.json',
            json_encode($contentLinkArr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

    return true;
}

function getEpisodesFromSeries(
    string $baseUrl,
    string $seriesSlug
) : bool {
    $client     = new Client();

    try {
        $response = $client->get($baseUrl . $seriesSlug);

        $content = (string) $response->getBody();
    } catch (ClientException $e) {
        echo $e->getMessage();

        return false;
    }

    if (empty($content)) {
        return false;
    }

    $domDocument = new \DOMDocument();
    $domDocument->loadHTML($content, LIBXML_NOERROR);

    $domXPath = new \DOMXPath($domDocument);

    $linkNodeList = $domXPath->query('//a');

    $episodeArr = [];

    for ($i = 0; $i < $linkNodeList->length; $i++) {
        $link = $linkNodeList
                ->item($i)
                ->attributes
                ->getNamedItem('href')
                ->nodeValue;

        if (preg_match('/serie\-episodio\-descargar\-torrent\-(?<episodeId>\d+)\-(?<episodeName>.+)\.html/', $link, $match)) {
            $episodeArr['episodes'][] = [
                'link'          => $link,
                'episodeId'     => (int) $match['episodeId'],
                'episodeName'   => $match['episodeName']
            ];
        }

        if (!empty($episodeArr)) {
            file_put_contents(
                '/scrap/json/episode.json',
                json_encode($episodeArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );
        }
    }

    return true;
}

function getEpisodeTorrent(
    string $baseUrl,
    string $episodeDownload,
    string $episodeDownloadTorrent,
    int $episode
) : bool {
    $client = new Client();

    try {
        $url = $baseUrl . sprintf($episodeDownload, $episode);

        $response = $client->get($url);

        $content = (string) $response->getBody();
    } catch (ClientException $e) {
        echo $e->getMessage() . "\n";

        return false;
    }

    $domDocument = new \DOMDocument();
    $domDocument->loadHTML($content, LIBXML_NOERROR);

    $domXPath = new \DOMXPath($domDocument);

    $iNode = $domXPath->query('//i');

    if (0 === $iNode->length) {
        return false;
    }

    try {
        $response = $client->get($baseUrl . $episodeDownloadTorrent . $iNode->item(0)->nodeValue);

        $content = (string) $response->getBody();

        file_put_contents(
            '/scrap/torrent/' . $iNode->item(0)->nodeValue,
            $content
        );
    } catch (ClientException $e) {
        echo $e->getMessage();

        return false;
    }

    return true;
}

$page = (!empty($argv[2]) ? $argv[2] : 1);

$series = json_decode(file_get_contents('/scrap/json/series.json'), true);
$episodes = json_decode(file_get_contents('/scrap/json/episode.json'), true);

if ('--force' === $argv[1]) {
    getSeriesLink($baseUrl, $seriesPage, $page);

    getEpisodesFromSeries($baseUrl, $series['series'][0]);
}

getEpisodeTorrent(
    $baseUrl,
    $download,
    $downloadTorrent,
    $episodes['episodes'][0]['episodeId']
);
