<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralCollectionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralCollectionMother
{

    public static function random(): ElementGeneralCollection
    {
        $total = MotherCreator::random()->numberBetween(1, 15);

        $elementGeneralCollection = new ElementGeneralCollection();

        for ($i = 0; $i < $total; $i++) {
            $elementGeneralCollection->add(
                ElementGeneralMother::random()
            );
        }

        return $elementGeneralCollection;
    }
}
