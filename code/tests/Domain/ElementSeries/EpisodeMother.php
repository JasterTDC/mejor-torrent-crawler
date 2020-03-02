<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class EpisodeMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class EpisodeMother
{

    /**
     * @return int
     */
    public static function random(): int
    {
        return MotherCreator::random()->numberBetween(1, 50000);
    }
}
