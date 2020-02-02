<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesTotalRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesTotalRawMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            [
                'total' => MotherCreator::random()->numberBetween(1)
            ]
        ];
    }
}
