<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesImageMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesImageMother
{

    /**
     * @return ElementSeriesImage
     */
    public static function random(): ElementSeriesImage
    {
        return new ElementSeriesImage(
            MotherCreator::random()->url,
            MotherCreator::random()->firstName
        );
    }
}
