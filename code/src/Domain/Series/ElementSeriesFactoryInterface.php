<?php


namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Interface ElementSeriesFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementSeriesFactoryInterface
{

    /**
     * @param array $rawElementSeries
     *
     * @return ElementSeries
     */
    public function createFromRaw(
        array $rawElementSeries
    ) : ElementSeries;

    /**
     * @param array $rawCollection
     *
     * @return ElementSeriesCollection
     */
    public function createCollectionFromRaw(
        array $rawCollection
    ) : ElementSeriesCollection;
}
