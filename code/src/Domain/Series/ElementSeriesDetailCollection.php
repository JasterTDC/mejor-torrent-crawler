<?php


namespace BestThor\ScrappingMaster\Domain\Series;

use BestThor\ScrappingMaster\Domain\BaseCollection;

/**
 * Class ElementSeriesDetailCollection
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailCollection extends BaseCollection
{

    /**
     * @param ElementSeriesDetail $elementSeriesDetail
     */
    public function add(ElementSeriesDetail $elementSeriesDetail)
    {
        $this->addToCollection(
            $elementSeriesDetail,
            $elementSeriesDetail->getId()
        );
    }
}
