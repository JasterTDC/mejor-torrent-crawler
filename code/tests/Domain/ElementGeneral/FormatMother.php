<?php


namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class FormatMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertc@gmail.com>
 */
final class FormatMother
{
    const ALLOWED_FORMATS = [
        'HDRip', 'DVDRip', 'MicroHD-1080p'
    ];

    /**
     * @return string
     */
    public static function random() : string
    {
        $randomIndex = MotherCreator::random()->numberBetween(0, 2);

        return self::ALLOWED_FORMATS[$randomIndex];
    }
}
