<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\General\ElementDetailContentEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementImageEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use BestThor\ScrappingMaster\Infrastructure\Repository\GuzzleMTContentReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralIdMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\EpisodeMother;
use BestThor\ScrappingMaster\Tests\Domain\Shared\PageMother;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class GuzzleMTContentReaderRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GuzzleMTContentReaderRepositoryTest extends TestCase
{
    /** @var string  */
    protected string $baseUrl;

    /** @var string  */
    protected string $generalUrl;

    /** @var string  */
    protected string $seriesUrl;

    /** @var string  */
    protected string $downloadUrl;

    /** @var string  */
    protected string $seriesDownloadUrl;

    /** @var Client */
    protected Client $client;

    /** @var GuzzleMTContentReaderRepository  */
    protected GuzzleMTContentReaderRepository $guzzleReader;

    protected function setUp(): void
    {
        $this->baseUrl = 'http://www.mejortorrentt.org';
        $this->generalUrl = '/secciones.php?sec=descargas&ap=peliculas&p=%s';
        $this->seriesUrl = '/secciones.php?sec=descargas&ap=series&p=%s';
        $this->downloadUrl = '/uploads/torrents/peliculas/';
        $this->seriesDownloadUrl = '/secciones.php?sec=descargas&ap=contar&tabla=series&id=%s';
    }

    public function testIfGetElementDetailUrlReturnsValid(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../general-detail.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementDetailContent(
                '/peli-descargar-torrent-21592-Ghostland.html'
            );

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfGetElementDetailContentThrowsException(): void
    {
        $this->expectException(ElementDetailContentEmptyException::class);

        $detailUrl = '/peli-descargar-torrent-21592-Ghostland.html';

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad request parameters',
                new Request(
                    'GET',
                    $detailUrl
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementDetailContent(
                $detailUrl
            );
    }

    public function testIfElementImageIsEmptyThenThrowsException(): void
    {
        $this->expectException(ElementImageEmptyException::class);

        $mockHandler = new MockHandler([
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementImageFile(
                ''
            );
    }

    public function testIfElementImageFileThrowsException(): void
    {
        $this->expectException(ElementImageEmptyException::class);

        $imageUrl = '/uploads/imagenes/peliculas/Ghostland.jpg';

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad request parameters',
                new Request(
                    'GET',
                    $imageUrl
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementImageFile($imageUrl);
    }

    public function testElementImageFileReturnsValid(): void
    {
        $imageUrl = '/uploads/imagenes/peliculas/Ghostland.jpg';

        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../237.jpg')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementImageFile($imageUrl);

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementGeneralThrowsException(): void
    {
        $this->expectException(ElementGeneralContentEmptyException::class);

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad request parameters',
                new Request(
                    'GET',
                    '/secciones.php?sec=descargas&ap=peliculas&p=1'
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementGeneralContent(PageMother::random());
    }

    public function testIfElementGeneralReturnsValidContent(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../general.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementGeneralContent(PageMother::random());

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementSeriesThrowsException(): void
    {
        $this->expectException(ElementSeriesEmptyException::class);

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad response',
                new Request(
                    'GET',
                    '/secciones.php?sec=descargas&ap=series&p=1'
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementSeriesContent(PageMother::random());
    }

    public function testElementSeriesReturnsValid(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../series.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementSeriesContent(PageMother::random());

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementDownloadUrlReturnsValid(): void
    {
        $mockHandler = new MockHandler([
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $downloadUrl = $this
            ->guzzleReader
            ->getElementDownloadUrl(ElementGeneralIdMother::random());

        $this->assertIsString($downloadUrl);
        $this->assertNotEmpty($downloadUrl);
    }

    public function testElementSeriesDetailThrowsException(): void
    {
        $this->expectException(ElementSeriesDetailEmptyException::class);

        $detailUrl = '/serie-descargar-torrents-64914-64915-The-Flash-6-Temporada.html';

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad response',
                new Request(
                    'GET',
                    $detailUrl
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementSeriesDetailContent($detailUrl);
    }

    public function testElementSeriesDetailReturnsValid(): void
    {
        $detailUrl = '/serie-descargar-torrents-64914-64915-The-Flash-6-Temporada.html';

        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../series-detail.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementSeriesDetailContent($detailUrl);

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementSeriesDetailDownloadThrowsException(): void
    {
        $this->expectException(ElementSeriesDetailEmptyException::class);

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad response',
                new Request(
                    'GET',
                    '/serie-episodio-descargar-torrent-64915-The-Flash-6x01.html'
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementSeriesDownloadContent(EpisodeMother::random());
    }

    public function testIfElementSeriesDetailDownloadReturnsValid(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../series-episode.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementSeriesDownloadContent(EpisodeMother::random());

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementDownloadThrowsException(): void
    {
        $this->expectException(ElementDownloadContentEmptyException::class);

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad response',
                new Request(
                    'GET',
                    '/secciones.php?sec=descargas&ap=contar&tabla=series&id=64915'
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementDownloadContent(ElementGeneralIdMother::random());
    }

    public function testIfElementDownloadReturnsValid(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../series-episode-download.html')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementDownloadContent(ElementGeneralIdMother::random());

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }

    public function testIfElementDownloadFileThrowsException(): void
    {
        $this->expectException(ElementDownloadContentEmptyException::class);

        $mockHandler = new MockHandler([
            new ClientException(
                'Bad response',
                new Request(
                    'GET',
                    '/uploads/torrents/peliculas/Ghostland.torrent'
                ),
                new Response(
                )
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $this
            ->guzzleReader
            ->getElementDownloadFile('/uploads/torrents/peliculas/Ghostland.torrent');
    }

    public function testIfElementDownloadFileReturnsValid(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../../970.torrent')
            )
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->client = new Client([
            'handler' => $handlerStack
        ]);

        $this->guzzleReader = new GuzzleMTContentReaderRepository(
            $this->baseUrl,
            $this->generalUrl,
            $this->seriesUrl,
            $this->downloadUrl,
            $this->seriesDownloadUrl,
            $this->client
        );

        $content = $this
            ->guzzleReader
            ->getElementDownloadFile('/uploads/torrents/peliculas/Ghostland.torrent');

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
    }
}
