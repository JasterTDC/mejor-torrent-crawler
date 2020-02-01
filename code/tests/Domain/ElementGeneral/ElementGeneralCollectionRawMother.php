<?php


namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralCollectionRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralCollectionRawMother
{

    /**
     * @return arrays
     */
    public static function random(): array
    {
        $total = MotherCreator::random()->numberBetween(2, 15);

        $ret = [];

        for($i = 0; $i < $total; $i++) {
            $ret[] = ElementGeneralRawMother::random();
        }

        return $ret;
    }
}
