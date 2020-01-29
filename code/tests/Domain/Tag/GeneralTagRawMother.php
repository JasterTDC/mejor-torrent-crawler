<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class GeneralTagRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralTagRawMother
{

    // Date format
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return array
     */
    public static function random(): array
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return [
            'generalId' => MotherCreator::random()->numberBetween(1),
            'tagId'     => MotherCreator::random()->numberBetween(1),
            'createdAt' => $dateCreated->format(self::DATE_FORMAT),
            'updatedAt' => $dateModified->format(self::DATE_FORMAT)
        ];
    }

    /**
     * @return array
     */
    public static function createWithRequiredOnly(): array
    {
        return [
            'generalId' => MotherCreator::random()->numberBetween(1),
            'tagId'     => MotherCreator::random()->numberBetween(1)
        ];
    }
}
