<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDescription;

/**
 * Class FromMysqlElementSeriesDescriptionFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class FromMysqlElementSeriesDescriptionFactory
{
    /**
     * @param array $rawElementSeriesDescription
     *
     * @return ElementSeriesDescription
     */
    public function createFromRaw(
        array $rawElementSeriesDescription
    ) : ElementSeriesDescription {
        return new ElementSeriesDescription(
            $rawElementSeriesDescription['description']
        );
    }
}
