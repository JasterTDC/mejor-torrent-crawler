<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesImageDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesImageMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesImageDataTransformer
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Freepik
 */
final class ElementSeriesImageDataTransformerTest extends TestCase
{
    /** @var ElementSeriesImageDataTransformer  */
    protected ElementSeriesImageDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementSeriesImageDataTransformer();
    }

    public function testSeriesImageTransform(): void
    {
        $seriesImage = ElementSeriesImageMother::random();

        $seriesImageTransformed = $this
            ->transformer
            ->transform($seriesImage);

        $this->assertIsArray($seriesImageTransformed);
        $this->assertNotEmpty($seriesImageTransformed);
        $this->assertArrayHasKey('imageUrl', $seriesImageTransformed);
        $this->assertArrayHasKey('imageName', $seriesImageTransformed);
        $this->assertEquals(
            $seriesImage->getImageUrl(),
            $seriesImageTransformed['imageUrl']
        );
        $this->assertEquals(
            $seriesImage->getImageName(),
            $seriesImageTransformed['imageName']
        );
    }
}
