<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\ElementSeriesDetailFactory;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDetailArrayMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDetailCollectionArrayMother;
use PHPUnit\Framework\TestCase;

/**
 * Class ElementSeriesDetailFactory
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailFactoryTest extends TestCase
{
    /** @var ElementSeriesDetailFactory  */
    protected ElementSeriesDetailFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ElementSeriesDetailFactory();
    }

    public function testIfArrayDataIsValid(): void
    {
        $elementDetail = $this
            ->factory
            ->createFromRaw(
                ElementSeriesDetailArrayMother::random()
            );

        $this->assertIsInt($elementDetail->getId());
        $this->assertIsString($elementDetail->getName());
        $this->assertIsString($elementDetail->getLink());
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getCreatedAt()
        );
        $this->assertInstanceOf(
            \DateTimeImmutable::class,
            $elementDetail->getUpdatedAt()
        );
        $this->assertNull($elementDetail->getSeriesId());
        $this->assertNull($elementDetail->getElementSeriesDownload());
    }

    public function testIfCollectionArrayIsValid(): void
    {
        $elementDetailCollection = $this
            ->factory
            ->createFromRawCollection(
                ElementSeriesDetailCollectionArrayMother::random()
            );

        $this->assertInstanceOf(
            ElementSeriesDetailCollection::class,
            $elementDetailCollection
        );
        $this->assertGreaterThan(1, $elementDetailCollection->count());
    }
}
