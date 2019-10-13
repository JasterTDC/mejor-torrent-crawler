<?php

$baseUrl = 'http://www.mejortorrentt.org/torrents-de-peliculas.html';
$homeUrl = 'http://www.mejortorrentt.org';

$filmUrl = '/secciones.php?sec=descargas&ap=peliculas&p=%s';
$downloadElementFilm = '/secciones.php?sec=descargas&ap=contar&tabla=peliculas&id=%s&link_bajar=1';
$downloadElementTorrent = '/uploads/torrents/peliculas/';

$linkArr = [];
$finalLinkArr = [];

for ($i = 1; $i < 2; $i++) {
    echo "[SCRAPPING]...Page: {$i}\n";

    $finalFilmUrl = sprintf(
        $filmUrl,
        $i
    );

    echo "[HTML]...{$finalFilmUrl}\n" ;

    $html = file_get_contents($homeUrl . $finalFilmUrl);

    if (empty($html)) {
        echo '[HTML]...We could not retrieve html from origin';
    }

    $domDocument = new DOMDocument();
    @$domDocument->loadHTML($html);

    $domXPath = new DOMXPath($domDocument);

    $linkTagList = $domXPath->query('//a');

    if (empty($linkTagList)) {
        echo '[HTML]...We could not find any interesting element';
    }

    echo "[HTML]...Elements: {$linkTagList->length}\n";

    for ($j = 0; $j < $linkTagList->length; $j++) {
        $hrefLink = $linkTagList->item($j)->attributes->getNamedItem('href');

        if (!empty($hrefLink)) {
            echo $hrefLink->textContent . "\n";

            $linkArr[] = $hrefLink->textContent;
        }
    }

    echo "[SCRAPPING]...End page {$i}\n";
}

foreach ($linkArr as $link) {
    $match = [];

    if (preg_match('/\/peli\-descargar\-torrent\-(?<elementId>\d+)\-(?<elementSlug>.*)\.html/', $link, $match)) {
        $finalLinkArr[] = [
            'elementId'     => (int) $match['elementId'],
            'elementName'   => preg_replace('/\-/', ' ', $match['elementSlug']),
            'elementSlug'   => $match['elementSlug'],
            'elementLink'   => $link
        ];
    }
}

$fullElementArr = [];

$current = new \DateTimeImmutable();

$fullElementArr['lastUpdated'] = $current->format('Y-m-d H:i:s');
$fullElementArr['films'] = [];

foreach ($finalLinkArr as $finalLink) {
    $contentHtml = file_get_contents($homeUrl . $finalLink['elementLink']);

    $fullElement = $finalLink;

    if (!empty($contentHtml)) {
        $finalDocumentDoc = new DOMDocument();
        @$finalDocumentDoc->loadHTML($contentHtml);

        $finalXPath = new DOMXPath($finalDocumentDoc);

        $centerContainer = $finalXPath->query('//table[@align="center"]');
        $coverImg = $finalXPath->query('//img[@width="120"]');

        if (!empty($centerContainer)) {
            $elementGeneralInfo = $centerContainer->item(0)->nodeValue;

            $elementGenre = [];
            $elementFormat = [];
            $elementDescription = [];
            $elementPublishedDate = [];

            preg_match_all(
                '/Género\:(?<elementGenre>[^\.]+)/',
                $elementGeneralInfo,
                $elementGenre
            );

            preg_match_all(
                '/Formato\:(?<elementFormat>.*[^\s])/',
                $elementGeneralInfo,
                $elementFormat
            );

            preg_match_all(
                '/Descripción\:(?<elementDescription>.*)/',
                $elementGeneralInfo,
                $elementDescription
            );

            preg_match_all(
                '/Fecha\:(?<elementDate>.*)/',
                $elementGeneralInfo,
                $elementPublishedDate
            );

            $elementGenre = str_replace(
                chr(160),
                '',
                $elementGenre['elementGenre'][0]
            );
            $elementGenre = str_replace(
                chr(194),
                '',
                $elementGenre
            );
            $elementGenre = preg_replace(
                '/\s/',
                '',
                $elementGenre
            );

            $elementFormat = str_replace(
                chr(160),
                '',
                $elementFormat['elementFormat'][0]
            );
            $elementFormat = str_replace(
                chr(194),
                '',
                $elementFormat
            );
            $elementFormat = preg_replace(
                '/\s/',
                '',
                $elementFormat
            );

            $elementPublishedDate = str_replace(
                chr(160),
                '',
                $elementPublishedDate['elementDate'][0]
            );
            $elementPublishedDate = str_replace(
                chr(194),
                '',
                $elementPublishedDate
            );
            $elementPublishedDate = preg_replace(
                '/\s/',
                '',
                $elementPublishedDate
            );

            $fullElement['elementPublishedDate'] = $elementPublishedDate;
            $fullElement['elementGenre'] = $elementGenre;
            $fullElement['elementFormat'] = $elementFormat;
            $fullElement['elementDescription'] = $elementDescription['elementDescription'][0];

            $currentDate = DateTimeImmutable::createFromFormat(
                'Y-m-d',
                $elementPublishedDate
            );

            if (is_bool($currentDate) && !$currentDate) {
                continue;
            }

            $yearDir = __DIR__ . '/scrap-torrent/' . $currentDate->format('Y');
            $monthDir = __DIR__ . '/scrap-torrent/' .
                $currentDate->format('Y') . '/' .
                $currentDate->format('m') . '/'
            ;

            if (!is_dir($yearDir)) {
                mkdir($yearDir);
            }

            if (!is_dir($monthDir)) {
                mkdir($monthDir);
            }

            if (!is_dir($monthDir . $fullElement['elementName'])) {
                mkdir($monthDir . $fullElement['elementName']);
            }

            $fullElement['elementDir'] = $monthDir .
                $fullElement['elementName'] . '/';
        }

        if (!empty($coverImg)) {
            $imgUrl = [];

            $fullElement['elementCoverImg'] = $coverImg
                ->item(0)
                ->attributes
                ->getNamedItem('data-cfsrc')
                ->nodeValue;

            preg_match_all(
                '/\/(?<elementCoverImgName>[^\/]+$)/',
                $fullElement['elementCoverImg'],
                $imgUrl
            );

            $fullElement['elementCoverImgName'] = $imgUrl['elementCoverImgName'][0];
        }

        $fullElement['elementDownloadLink'] = sprintf(
            $downloadElementFilm,
            $fullElement['elementId']
        );

        $downloadElementHtml = file_get_contents(
            $homeUrl . $fullElement['elementDownloadLink']
        );

        if (!empty($downloadElementHtml)) {
            $downloadElementDomDoc = new DOMDocument();
            @$downloadElementDomDoc->loadHTML(
                $downloadElementHtml
            );

            $downloadElementXPath = new DOMXPath(
                $downloadElementDomDoc
            );

            $downloadTorrentContainer = $downloadElementXPath->query('//i');

            if (!empty($downloadTorrentContainer)) {
                $downloadTorrentName = $downloadTorrentContainer
                    ->item(0)
                    ->nodeValue;

                $downloadElementTorrentFile = $homeUrl .
                    $downloadElementTorrent .
                    $downloadTorrentName;

                $downloadElementTorrentFileContent = file_get_contents($downloadElementTorrentFile);

                file_put_contents(
                    $fullElement['elementDir'] . $downloadTorrentName,
                    $downloadElementTorrentFileContent
                );

                $imgContent = file_get_contents(
                    $homeUrl . $fullElement['elementCoverImg']
                );

                if (!empty($imgContent)) {
                    file_put_contents(
                        $fullElement['elementDir'] . $fullElement['elementCoverImgName'],
                        $imgContent
                    );
                }

                file_put_contents(
                    $fullElement['elementDir'] . $fullElement['elementSlug'] . '.json',
                    json_encode($fullElement, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                );
            }
        }

        $fullElementArr['films'][] = $fullElement;
    }
}

file_put_contents(__DIR__ . '/scrap-json/'.md5(time()) . '.json',
    json_encode($fullElementArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);
