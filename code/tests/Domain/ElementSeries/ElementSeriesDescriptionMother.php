<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDescription;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDescriptionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDescriptionMother
{

    /**
     * @return ElementSeriesDescription
     */
    public static function random(): ElementSeriesDescription
    {
        return new ElementSeriesDescription(
            MotherCreator::random()->text
        );
    }
}
