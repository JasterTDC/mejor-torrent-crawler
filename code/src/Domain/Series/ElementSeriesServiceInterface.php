<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Interface ElementSeriesServiceInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementSeriesServiceInterface
{
    /**
     * @param int $page
     *
     * @return ElementSeriesCollection
     */
    public function getElementSeriesCollectionByPage(
        int $page
    ): ElementSeriesCollection;
}
