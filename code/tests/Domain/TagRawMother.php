<?php


namespace BestThor\ScrappingMaster\Tests\Domain;

/**
 * Class TagMother
 *
 * @package BestThor\ScrappingMaster\Test\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagRawMother
{

    // Date format
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return array
     */
    public static function random() : array
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
            'id' => MotherCreator::random()->numberBetween(1),
            'name' => MotherCreator::random()->lastName,
            'createdAt' => $dateCreated->format(self::DATE_FORMAT),
            'updatedAt' => $dateModified->format(self::DATE_FORMAT)
        ];
    }

    /**
     * @return array
     */
    public static function createWithOnlyName() : array
    {
        return [
            'name' => MotherCreator::random()->lastName
        ];
    }

    /**
     * @return array
     */
    public static function createWithoutId() : array
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
            'name' => MotherCreator::random()->lastName,
            'createdAt' => $dateCreated->format(self::DATE_FORMAT),
            'updatedAt' => $dateModified->format(self::DATE_FORMAT)
        ];
    }
}
