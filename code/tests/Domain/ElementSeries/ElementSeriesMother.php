<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDescription;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesMother
{
    // Date format
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return ElementSeries
     */
    public static function createWithoutEpisodes(): ElementSeries
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new ElementSeries(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->firstName,
            MotherCreator::random()->slug,
            MotherCreator::random()->url,
            $dateCreated,
            $dateModified,
            null,
            null,
            null
        );
    }

    /**
     * @return ElementSeries
     */
    public static function create(): ElementSeries
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        return new ElementSeries(
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->numberBetween(1),
            MotherCreator::random()->firstName,
            MotherCreator::random()->slug,
            MotherCreator::random()->url,
            $dateCreated,
            $dateModified,
            ElementSeriesImageMother::random(),
            ElementSeriesDescriptionMother::random(),
            ElementSeriesDetailCollectionMother::random()
        );
    }
}
