<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDetailArrayMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailArrayMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            'id'    => MotherCreator::random()->numberBetween(1),
            'name'  => MotherCreator::random()->word,
            'link'  => MotherCreator::random()->url
        ];
    }
}
