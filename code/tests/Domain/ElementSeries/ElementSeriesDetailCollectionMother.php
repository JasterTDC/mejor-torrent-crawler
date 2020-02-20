<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDetailCollectionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailCollectionMother
{

    /**
     * @return ElementSeriesDetailCollection
     */
    public static function random(): ElementSeriesDetailCollection
    {
        $detailCollection = new ElementSeriesDetailCollection();

        $total = MotherCreator::random()->numberBetween(10, 25);

        for ($i = 0; $i < $total; $i++) {
            $detailCollection->add(
                ElementSeriesDetailMother::random()
            );
        }

        return $detailCollection;
    }
}
