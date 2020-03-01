<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries;

use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesRawMother;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesFactoryTest extends TestCase
{

    /** @var ElementSeriesFactory */
    protected ElementSeriesFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ElementSeriesFactory();
    }

    public function testIfParametersAreValid(): void
    {
        $series = $this
            ->factory
            ->createFromRaw(
                ElementSeriesRawMother::random()
            );

        $this->assertIsInt($series->getId());
        $this->assertIsInt($series->getFirstEpId());
        $this->assertIsString($series->getName());
        $this->assertIsString($series->getSlug());
        $this->assertIsString($series->getLink());
        $this->assertInstanceOf(
            DateTimeImmutable::class,
            $series->getCreatedAt()
        );
        $this->assertInstanceOf(
            DateTimeImmutable::class,
            $series->getUpdatedAt()
        );
    }

    public function testIfCollectionIsNotEmpty(): void
    {
        $seriesCollection = $this
            ->factory
            ->createFromRawCollection(
                ElementSeriesCollectionRawMother::random()
            );

        $this->assertGreaterThanOrEqual(2, $seriesCollection->count());
    }
}
