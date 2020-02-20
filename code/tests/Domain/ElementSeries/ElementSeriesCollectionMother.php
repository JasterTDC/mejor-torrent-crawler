<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesCollectionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesCollectionMother
{
    /**
     * @return ElementSeriesCollection
     */
    public static function random(): ElementSeriesCollection
    {
        $total = MotherCreator::random()->numberBetween(10, 20);

        $elementSeriesCollection = new ElementSeriesCollection();

        for ($i = 0; $i < $total; $i++) {
            $elementSeriesCollection->add(
                ElementSeriesMother::create()
            );
        }

        return $elementSeriesCollection;
    }
}
