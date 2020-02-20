<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDetailMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailMother
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return ElementSeriesDetail
     */
    public static function random(): ElementSeriesDetail
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new ElementSeriesDetail(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->lastName,
            MotherCreator::random()->url,
            $dateCreated,
            $dateModified,
            ElementSeriesDownloadMother::random()
        );
    }

    /**
     * @return ElementSeriesDetail
     */
    public static function createWithoutDownload(): ElementSeriesDetail
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new ElementSeriesDetail(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->lastName,
            MotherCreator::random()->url,
            $dateCreated,
            $dateModified,
            null
        );
    }
}
