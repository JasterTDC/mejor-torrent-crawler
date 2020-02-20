<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementDetailRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailRawMother
{
    public const GENRE_ATTR = 'genre';
    public const FORMAT_ATTR = 'format';
    public const DESCRIPTION_ATTR = 'description';
    public const COVER_IMG_ATTR = 'coverImg';
    public const COVER_IMG_NAME_ATTR = 'coverImgName';
    public const PUBLISHED_DATE_ATTR = 'publishedDate';

    protected const DATETIME_FORMAT = 'Y-m-d H:i:s';
    protected const DATE_FORMAT = 'Y-m-d';

    /**
     * @return array
     */
    public static function random(): array
    {
        return [
            self::GENRE_ATTR            => GenreMother::random(),
            self::FORMAT_ATTR           => FormatMother::random(),
            self::DESCRIPTION_ATTR      => DescriptionMother::random(),
            self::COVER_IMG_ATTR        => ImagePathMother::random(),
            self::COVER_IMG_NAME_ATTR   => ImageNameMother::random(),
            self::PUBLISHED_DATE_ATTR   => MotherCreator::random()
                ->dateTimeThisDecade()
                ->format(self::DATETIME_FORMAT)
        ];
    }

    /**
     * @return array
     */
    public static function missingImage(): array
    {
        return [
            self::GENRE_ATTR            => GenreMother::random(),
            self::FORMAT_ATTR           => FormatMother::random(),
            self::DESCRIPTION_ATTR      => DescriptionMother::random()
        ];
    }

    public static function create(): array
    {
        return [
            self::GENRE_ATTR            => GenreMother::random(),
            self::FORMAT_ATTR           => FormatMother::random(),
            self::DESCRIPTION_ATTR      => DescriptionMother::random(),
            self::COVER_IMG_ATTR        => ImagePathMother::random(),
            self::COVER_IMG_NAME_ATTR   => ImageNameMother::random(),
            self::PUBLISHED_DATE_ATTR   => MotherCreator::random()
                ->dateTimeThisDecade()
                ->format(self::DATE_FORMAT)
        ];
    }
}
