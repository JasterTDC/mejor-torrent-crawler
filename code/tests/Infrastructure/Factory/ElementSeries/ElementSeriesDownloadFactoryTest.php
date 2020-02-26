<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries;

use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesDownloadFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\DownloadTorrentUrlMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDownloadArrayMother;
use Monolog\Test\TestCase;

/**
 * Class ElementSeriesDownloadFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadFactoryTest extends TestCase
{

    /** @var ElementSeriesDownloadFactory  */
    protected ElementSeriesDownloadFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ElementSeriesDownloadFactory(
            DownloadTorrentUrlMother::random()
        );
    }

    public function testIfParametersAreValid(): void
    {
        $seriesDownload = $this
            ->factory
            ->createFromRaw(ElementSeriesDownloadArrayMother::random());

        $this->assertIsString(
            $seriesDownload->getDownloadLink()
        );
        $this->assertIsString(
            $seriesDownload->getDownloadName()
        );
    }
}
