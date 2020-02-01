<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class GeneralTotalMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralTotalMother
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
