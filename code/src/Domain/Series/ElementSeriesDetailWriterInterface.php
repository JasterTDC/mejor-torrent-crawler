<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Interface ElementSeriesDetailWriterInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementSeriesDetailWriterInterface
{

    /**
     * @param ElementSeriesDetail $elementSeriesDetail
     *
     * @return bool
     * @throws ElementSeriesDetailSaveException
     */
    public function persist(
        ElementSeriesDetail $elementSeriesDetail
    ): bool;
}
