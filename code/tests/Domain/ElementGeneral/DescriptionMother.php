<?php


namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class DescriptionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class DescriptionMother
{

    /**
     * @return string
     */
    public static function random() : string
    {
        return MotherCreator::random()->text();
    }
}
