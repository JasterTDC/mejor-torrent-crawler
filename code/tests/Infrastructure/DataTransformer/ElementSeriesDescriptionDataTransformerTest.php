<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDescriptionDataTransformer;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDescriptionMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesDescriptionDataTransformerTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDescriptionDataTransformerTest extends TestCase
{
    /** @var ElementSeriesDescriptionDataTransformer */
    protected ElementSeriesDescriptionDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ElementSeriesDescriptionDataTransformer();
    }

    public function testTransformedDescription(): void
    {
        $seriesDescription = ElementSeriesDescriptionMother::random();

        $transformed = $this
            ->transformer
            ->transform($seriesDescription);

        $this->assertEquals(
            $transformed,
            $seriesDescription->getDescription()
        );
    }
}
