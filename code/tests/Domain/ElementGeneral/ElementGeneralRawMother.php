<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralRawMother
{

    public const ID_ATTR = 'id';
    public const NAME_ATTR = 'name';
    public const SLUG_ATTR = 'slug';
    public const LINK_ATTR = 'link';
    public const CREATED_AT_ATTR = 'createdAt';
    public const UPDATED_AT_ATTR = 'updatedAt';
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

        $rawElementGeneral = [
            self::ID_ATTR => MotherCreator::random()->numberBetween(1),
            self::NAME_ATTR => MotherCreator::random()->lastName,
            self::SLUG_ATTR => MotherCreator::random()->slug,
            self::LINK_ATTR => MotherCreator::random()->url,
            self::CREATED_AT_ATTR => $dateCreated->format(self::DATE_FORMAT),
            self::UPDATED_AT_ATTR => $dateModified->format(self::DATE_FORMAT)
        ];

        $rawElementDetail = ElementDetailRawMother::random();
        $rawElementDownload = ElementGeneralDownloadRawMother::random();

        $rawElementGeneral = array_merge($rawElementGeneral, $rawElementDetail);

        return array_merge($rawElementGeneral, $rawElementDownload);
    }
}
