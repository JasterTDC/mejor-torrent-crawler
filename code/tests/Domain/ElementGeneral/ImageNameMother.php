<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ImageNameMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ImageNameMother
{
    /**
     * @return string
     */
    public static function random(): string
    {
        return MotherCreator::random()->lastName . '.jpg';
    }
}
