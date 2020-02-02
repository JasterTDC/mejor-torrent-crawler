<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesRawMother
{
    public const ID_ATTR = 'id';
    public const FIRST_EPISODE_ID_ATTR = 'firstEpId';
    public const NAME_ATTR = 'name';
    public const SLUG_ATTR = 'slug';
    public const LINK_ATTR = 'link';
    public const DESCRIPTION_ATTR = 'description';
    public const IMAGE_NAME_ATTR = 'imageName';
    public const IMAGE_URL_ATTR = 'imageUrl';

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            self::ID_ATTR => MotherCreator::random()->numberBetween(1),
            self::FIRST_EPISODE_ID_ATTR => MotherCreator::random()->numberBetween(1),
            self::NAME_ATTR => MotherCreator::random()->firstName,
            self::SLUG_ATTR => MotherCreator::random()->slug,
            self::LINK_ATTR => MotherCreator::random()->url,
            self::DESCRIPTION_ATTR => MotherCreator::random()->text,
            self::IMAGE_NAME_ATTR => MotherCreator::random()->firstName,
            self::IMAGE_URL_ATTR => MotherCreator::random()->url
        ];
    }
}
