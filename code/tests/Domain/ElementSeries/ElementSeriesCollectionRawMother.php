<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesCollectionRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesCollectionRawMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        $total = MotherCreator::random()->numberBetween(2, 15);

        $ret = [];

        for ($i = 0; $i < $total; $i++) {
            $ret[] = ElementSeriesRawMother::random();
        }

        return $ret;
    }
}
