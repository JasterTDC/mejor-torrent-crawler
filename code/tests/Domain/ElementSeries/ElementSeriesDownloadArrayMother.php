<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDownloadArrayMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadArrayMother
{

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            'name' => MotherCreator::random()->word
        ];
    }
}
