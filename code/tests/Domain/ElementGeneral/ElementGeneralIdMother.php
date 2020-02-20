<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralIdMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralIdMother
{

    /**
     * @return int
     */
    public static function random(): int
    {
        return MotherCreator::random()->numberBetween(1, 25565);
    }
}
