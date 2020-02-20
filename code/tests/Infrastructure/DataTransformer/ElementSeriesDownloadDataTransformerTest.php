<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDownloadMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesDownloadDataTransformerTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadDataTransformerTest extends TestCase
{
    protected const NAME_ATTR = 'name';
    protected const LINK_ATTR = 'link';

    /** @var ElementSeriesDownloadDataTransformer  */
    protected ElementSeriesDownloadDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementSeriesDownloadDataTransformer();
    }

    public function testSeriesDownloadTransformValid(): void
    {
        $seriesDownload = ElementSeriesDownloadMother::random();

        $transformed = $this
            ->transformer
            ->transform($seriesDownload);

        $this->assertIsArray($transformed);
        $this->assertNotEmpty($transformed);
        $this->assertArrayHasKey(
            self::NAME_ATTR,
            $transformed
        );
        $this->assertArrayHasKey(
            self::LINK_ATTR,
            $transformed
        );
        $this->assertEquals(
            $seriesDownload->getDownloadName(),
            $transformed[self::NAME_ATTR]
        );
        $this->assertEquals(
            $seriesDownload->getDownloadLink(),
            $transformed[self::LINK_ATTR]
        );
    }
}
