<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDescriptionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDetailDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDownloadDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesImageDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesCollectionMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesDataTransformerTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDataTransformerTest extends TestCase
{
    protected const ID = 'id';
    protected const FIRST_EPISODE_ID = 'firstEpId';
    protected const NAME = 'name';
    protected const SLUG = 'slug';
    protected const LINK = 'link';
    protected const DETAIL_COLLECTION = 'detailCollection';
    protected const DESCRIPTION = 'description';
    protected const IMAGE = 'image';

    /** @var ElementSeriesDataTransformer  */
    protected ElementSeriesDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementSeriesDataTransformer(
            new ElementSeriesImageDataTransformer(),
            new ElementSeriesDescriptionDataTransformer(),
            new ElementSeriesDetailDataTransformer(
                new ElementSeriesDownloadDataTransformer()
            )
        );
    }

    public function testElementSeriesTransform(): void
    {
        $series = ElementSeriesMother::create();

        $seriesTransformed = $this
            ->transformer
            ->transform($series);

        $this->assertIsArray($seriesTransformed);
        $this->assertNotEmpty($seriesTransformed);
        $this->assertArrayHasKey(
            self::ID,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getId(),
            $seriesTransformed[self::ID]
        );
        $this->assertArrayHasKey(
            self::LINK,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getLink(),
            $seriesTransformed[self::LINK]
        );
        $this->assertArrayHasKey(
            self::NAME,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getName(),
            $seriesTransformed[self::NAME]
        );
        $this->assertArrayHasKey(
            self::SLUG,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getSlug(),
            $seriesTransformed[self::SLUG]
        );
        $this->assertArrayHasKey(
            self::FIRST_EPISODE_ID,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getFirstEpId(),
            $seriesTransformed[self::FIRST_EPISODE_ID]
        );
        $this->assertArrayHasKey(
            self::IMAGE,
            $seriesTransformed
        );
        $this->assertNotEmpty($seriesTransformed[self::IMAGE]);
        $this->assertArrayHasKey(
            self::DESCRIPTION,
            $seriesTransformed
        );
        $this->assertNotEmpty($seriesTransformed[self::DESCRIPTION]);
        $this->assertArrayHasKey(
            self::DETAIL_COLLECTION,
            $seriesTransformed
        );
        $this->assertIsArray($seriesTransformed[self::DETAIL_COLLECTION]);
    }

    public function testElementSeriesWithRequiredOnly(): void
    {
        $series = ElementSeriesMother::createWithoutEpisodes();

        $seriesTransformed = $this
            ->transformer
            ->transform($series);

        $this->assertIsArray($seriesTransformed);
        $this->assertNotEmpty($seriesTransformed);
        $this->assertArrayHasKey(
            self::ID,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getId(),
            $seriesTransformed[self::ID]
        );
        $this->assertArrayHasKey(
            self::LINK,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getLink(),
            $seriesTransformed[self::LINK]
        );
        $this->assertArrayHasKey(
            self::NAME,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getName(),
            $seriesTransformed[self::NAME]
        );
        $this->assertArrayHasKey(
            self::SLUG,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getSlug(),
            $seriesTransformed[self::SLUG]
        );
        $this->assertArrayHasKey(
            self::FIRST_EPISODE_ID,
            $seriesTransformed
        );
        $this->assertEquals(
            $series->getFirstEpId(),
            $seriesTransformed[self::FIRST_EPISODE_ID]
        );
    }

    public function testElementSeriesCollectionTransform(): void
    {
        $seriesCollection = ElementSeriesCollectionMother::random();

        $collectionTransformed = $this
            ->transformer
            ->transformCollection($seriesCollection);

        $this->assertIsArray($collectionTransformed);
        $this->assertNotEmpty($collectionTransformed);
    }
}
