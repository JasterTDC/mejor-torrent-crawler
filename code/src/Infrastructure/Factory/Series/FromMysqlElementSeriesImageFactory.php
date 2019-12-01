<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;

/**
 * Class FromMysqlElementSeriesImageFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class FromMysqlElementSeriesImageFactory
{

    /**
     * @param array $rawElementSeriesImage
     *
     * @return ElementSeriesImage
     */
    public function createFromRaw(
        array $rawElementSeriesImage
    ) : ElementSeriesImage {
        return new ElementSeriesImage(
            $rawElementSeriesImage['imageUrl'],
            $rawElementSeriesImage['imageName']
        );
    }
}
