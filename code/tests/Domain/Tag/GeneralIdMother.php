<?php


namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class GeneralIdMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralIdMother
{

    /**
     * @return int
     */
    public static function random(): int
    {
        return MotherCreator::random()->numberBetween(1);
    }
}
