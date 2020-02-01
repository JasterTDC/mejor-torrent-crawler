<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Interface ElementSeriesWriterInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementSeriesWriterInterface
{
    /**
     * @param ElementSeries $elementSeries
     *
     * @return bool
     * @throws ElementSeriesSaveException
     */
    public function persist(
        ElementSeries $elementSeries
    ): bool;
}
