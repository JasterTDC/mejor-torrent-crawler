<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesImageArrayMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesImageArrayMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            'imageName' => MotherCreator::random()->word,
            'imageUrl'  => MotherCreator::random()->imageUrl()
        ];
    }
}
