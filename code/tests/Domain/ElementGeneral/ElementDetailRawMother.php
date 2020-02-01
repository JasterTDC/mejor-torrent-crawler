<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

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
            self::COVER_IMG_NAME_ATTR   => ImageNameMother::random()
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
}
