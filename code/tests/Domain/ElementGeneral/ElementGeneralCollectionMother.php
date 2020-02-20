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

    /**
     * @return ElementGeneralCollection
     */
    public static function random(): ElementGeneralCollection
    {
        $total = MotherCreator::random()->numberBetween(2, 15);

        $elementGeneralCollection = new ElementGeneralCollection();

        for ($i = 0; $i < $total; $i++) {
            $elementGeneralCollection->add(
                ElementGeneralMother::random()
            );
        }

        return $elementGeneralCollection;
    }

    /**
     * @return ElementGeneralCollection
     */
    public static function createWithEmptyDetail(): ElementGeneralCollection
    {
        $total = MotherCreator::random()->numberBetween(15, 20);

        $elementGeneralCollection = new ElementGeneralCollection();

        for ($i = 0; $i < $total; $i++) {
            $elementGeneralCollection->add(
                ElementGeneralMother::createWithEmptyDetail()
            );
        }

        return $elementGeneralCollection;
    }

    /**
     * @return ElementGeneralCollection
     */
    public static function createWithEmptyDownload(): ElementGeneralCollection
    {
        $total = MotherCreator::random()->numberBetween(15, 20);

        $elementGeneralCollection = new ElementGeneralCollection();

        for ($i = 0; $i < $total; $i++) {
            $elementGeneralCollection->add(
                ElementGeneralMother::createWithEmptyDownload()
            );
        }

        return $elementGeneralCollection;
    }
}
