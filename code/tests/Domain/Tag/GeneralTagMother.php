<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Domain\Tag\GeneralTag;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class GeneralTagMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralTagMother
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return GeneralTag
     */
    public static function random(): GeneralTag
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new GeneralTag(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->numberBetween(1),
            $dateCreated,
            $dateModified
        );
    }
}
