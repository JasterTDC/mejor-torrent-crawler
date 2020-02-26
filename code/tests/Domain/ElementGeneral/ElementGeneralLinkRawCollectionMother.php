<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralLinkRawCollectionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralLinkRawCollectionMother
{

    /**
     * @return string
     */
    public static function random(): string
    {
        $ret = '';

        $total = MotherCreator::random()->numberBetween(10, 25);

        for ($i = 0; $i < $total; $i++) {
            $ret .= ElementGeneralLinkRawMother::random();
        }

        return $ret;
    }
}
