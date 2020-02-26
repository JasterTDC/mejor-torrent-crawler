<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDetailCollectionArrayMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailCollectionArrayMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        $total = MotherCreator::random()->numberBetween(10, 30);

        $ret = [];

        for ($i = 0; $i < $total; $i++) {
            $ret[] = ElementSeriesDetailArrayMother::random();
        }

        return $ret;
    }
}
