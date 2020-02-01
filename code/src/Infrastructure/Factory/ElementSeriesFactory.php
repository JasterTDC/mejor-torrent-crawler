<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory;

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;

/**
 * Class ElementSeriesFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesFactory
{
    /**
     * @param array $rawElementSeries
     *
     * @return ElementSeries
     * @throws \Exception
     */
    public function createFromRaw(
        array $rawElementSeries
    ): ElementSeries {
        return new ElementSeries(
            (int) $rawElementSeries['id'],
            (int) $rawElementSeries['firstEpId'],
            $rawElementSeries['name'],
            $rawElementSeries['slug'],
            $rawElementSeries['link'],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            null,
            null,
            null
        );
    }

    /**
     * @param array $rawElementSeriesCollection
     *
     * @return ElementSeriesCollection
     */
    public function createFromRawCollection(
        array $rawElementSeriesCollection
    ): ElementSeriesCollection {
        $collection = new ElementSeriesCollection();

        foreach ($rawElementSeriesCollection as $rawElementSeries) {
            $collection->add(
                $this->createFromRaw($rawElementSeries)
            );
        }

        return $collection;
    }
}
