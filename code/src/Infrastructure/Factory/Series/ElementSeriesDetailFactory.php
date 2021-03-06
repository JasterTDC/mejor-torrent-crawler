<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;

/**
 * Class ElementSeriesDetailFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailFactory
{

    /**
     * @param array $rawElementSeriesDetail
     *
     * @return ElementSeriesDetail
     */
    public function createFromRaw(
        array $rawElementSeriesDetail
    ): ElementSeriesDetail {
        return new ElementSeriesDetail(
            $rawElementSeriesDetail['id'],
            null,
            $rawElementSeriesDetail['name'],
            $rawElementSeriesDetail['link'],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            null
        );
    }

    /**
     * @param array $rawCollection
     *
     * @return ElementSeriesDetailCollection
     */
    public function createFromRawCollection(
        array $rawCollection
    ): ElementSeriesDetailCollection {
        $collection = new ElementSeriesDetailCollection();

        foreach ($rawCollection as $rawElementSeriesDetail) {
            $collection->add(
                $this->createFromRaw($rawElementSeriesDetail)
            );
        }

        return $collection;
    }
}
