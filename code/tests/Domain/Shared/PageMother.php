<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Shared;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class PageMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Shared
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class PageMother
{

    /**
     * @return int
     */
    public static function random(): int
    {
        return MotherCreator::random()->numberBetween(1, 150);
    }
}
