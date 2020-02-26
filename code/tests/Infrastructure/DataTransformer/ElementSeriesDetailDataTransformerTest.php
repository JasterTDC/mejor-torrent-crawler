<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDetailDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDetailCollectionMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDetailMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesDetailDataTransformerTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailDataTransformerTest extends TestCase
{

    protected const ID = 'id';
    protected const NAME = 'name';
    protected const LINK = 'link';
    protected const DOWNLOAD = 'download';

    /** @var ElementSeriesDetailDataTransformer  */
    protected ElementSeriesDetailDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementSeriesDetailDataTransformer(
            new ElementSeriesDownloadDataTransformer()
        );
    }

    public function testElementSeriesDetailTransform(): void
    {
        $seriesDetail = ElementSeriesDetailMother::random();

        $seriesDetailTransformed = $this
            ->transformer
            ->transform($seriesDetail);

        $this->assertIsArray($seriesDetailTransformed);
        $this->assertNotEmpty($seriesDetailTransformed);
        $this->assertArrayHasKey(
            self::ID,
            $seriesDetailTransformed
        );
        $this->assertArrayHasKey(
            self::NAME,
            $seriesDetailTransformed
        );
        $this->assertArrayHasKey(
            self::LINK,
            $seriesDetailTransformed
        );
        $this->assertArrayHasKey(
            self::DOWNLOAD,
            $seriesDetailTransformed
        );
        $this->assertNotEmpty(
            $seriesDetailTransformed[self::DOWNLOAD]
        );
        $this->assertEquals(
            $seriesDetail->getId(),
            $seriesDetailTransformed[self::ID]
        );
        $this->assertEquals(
            $seriesDetail->getName(),
            $seriesDetailTransformed[self::NAME]
        );
        $this->assertEquals(
            $seriesDetail->getLink(),
            $seriesDetailTransformed[self::LINK]
        );
    }

    public function testSeriesDetailWithoutDownloadTransform(): void
    {
        $seriesDetail = ElementSeriesDetailMother::createWithoutDownload();

        $seriesDetailTransformed = $this
            ->transformer
            ->transform($seriesDetail);

        $this->assertIsArray($seriesDetailTransformed);
        $this->assertNotEmpty($seriesDetailTransformed);
        $this->assertArrayHasKey(
            self::ID,
            $seriesDetailTransformed
        );
        $this->assertArrayHasKey(
            self::NAME,
            $seriesDetailTransformed
        );
        $this->assertArrayHasKey(
            self::LINK,
            $seriesDetailTransformed
        );
        $this->assertArrayNotHasKey(
            self::DOWNLOAD,
            $seriesDetailTransformed
        );
        $this->assertEquals(
            $seriesDetail->getId(),
            $seriesDetailTransformed[self::ID]
        );
        $this->assertEquals(
            $seriesDetail->getName(),
            $seriesDetailTransformed[self::NAME]
        );
        $this->assertEquals(
            $seriesDetail->getLink(),
            $seriesDetailTransformed[self::LINK]
        );
    }

    public function testTransformElementSeriesDetailCollection(): void
    {
        $seriesCollection = ElementSeriesDetailCollectionMother::random();

        $transformed = $this
            ->transformer
            ->transformCollection($seriesCollection);

        $this->assertIsArray($transformed);
        $this->assertNotEmpty($transformed);
    }
}
