<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries;

use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesImageFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesImageArrayMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesImageFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesImageFactoryTest extends TestCase
{

    /** @var ElementSeriesImageFactory */
    protected ElementSeriesImageFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ElementSeriesImageFactory();
    }

    public function testIfParametersAreValid(): void
    {
        $seriesImage = $this
            ->factory
            ->createFromRaw(
                ElementSeriesImageArrayMother::random()
            );

        $this->assertIsString(
            $seriesImage->getImageName()
        );
        $this->assertIsString(
            $seriesImage->getImageUrl()
        );
    }
}
