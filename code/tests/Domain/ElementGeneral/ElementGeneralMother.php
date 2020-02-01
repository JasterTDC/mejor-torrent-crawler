<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralMother
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return ElementGeneral
     */
    public static function random(): ElementGeneral
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new ElementGeneral(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->lastName,
            MotherCreator::random()->slug,
            MotherCreator::random()->url,
            $dateCreated,
            $dateModified,
            ElementDetailMother::random(),
            ElementGeneralDownloadMother::random()
        );
    }
}
