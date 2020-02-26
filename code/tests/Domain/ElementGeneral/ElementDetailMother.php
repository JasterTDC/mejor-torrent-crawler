<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Domain\General\ElementDetail;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementDetailMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailMother
{
    /**
     * @return ElementDetail
     */
    public static function random(): ElementDetail
    {
        $date = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisDecade
        );

        return new ElementDetail(
            $date,
            GenreMother::random(),
            FormatMother::random(),
            DescriptionMother::random(),
            ImagePathMother::random(),
            ImageNameMother::random()
        );
    }
}
