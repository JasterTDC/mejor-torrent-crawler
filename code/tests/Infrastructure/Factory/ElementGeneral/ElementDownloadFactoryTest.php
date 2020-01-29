<?php


namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementGeneral;

use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\DownloadMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementDownloadFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
class ElementDownloadFactoryTest extends TestCase
{

    const DOWNLOAD_PATH = '/uploads/torrents/peliculas/';

    /** @var ElementDownloadFactory */
    protected $elementDownloadFactory;

    protected function setUp(): void
    {
        $this->elementDownloadFactory = new ElementDownloadFactory(
            self::DOWNLOAD_PATH
        );
    }

    protected function tearDown(): void
    {
        $this->elementDownloadFactory = null;
    }

    public function testIfDownloadNameIsEmptyThenNullIsReturned()
    {
        $elementDownload = $this
            ->elementDownloadFactory
            ->createFromRaw([]);

        $this->assertNull($elementDownload);
    }

    public function testIfDownloadNameIsValidThenObjectIsCreated()
    {
        $rawElementDownload = DownloadMother::random();

        $elementDownload = $this
            ->elementDownloadFactory
            ->createFromRaw($rawElementDownload);

        $this->assertEquals(
            $rawElementDownload['downloadName'],
            $elementDownload->getElementDownloadName()
        );
        $this->assertEquals(
            DownloadMother::DOWNLOAD_PATH .
            $elementDownload->getElementDownloadName(),
            $elementDownload->getElementDownloadTorrentUrl()
        );
    }
}
