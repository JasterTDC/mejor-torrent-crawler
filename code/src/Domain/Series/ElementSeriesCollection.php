<?php

namespace BestThor\ScrappingMaster\Domain\Series;

use BestThor\ScrappingMaster\Domain\BaseCollection;

/**
 * Class ElementSeriesCollection
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesCollection extends BaseCollection
{
    /**
     * @param ElementSeries $elementSeries
     */
    public function add(ElementSeries $elementSeries)
    {
        $this->addToCollection(
            $elementSeries,
            $elementSeries->getId()
        );
    }
}
