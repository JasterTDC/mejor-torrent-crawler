<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Interface ElementSeriesReaderInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementSeriesReaderInterface
{

    /**
     * @param int $page
     * @param int $limit
     *
     * @return ElementSeriesCollection
     */
    public function getElementSeriesByPageAndLimit(
        int $page,
        int $limit
    ): ElementSeriesCollection;

    /**
     * Get total
     *
     * @return int
     */
    public function getTotal(): int;
}
