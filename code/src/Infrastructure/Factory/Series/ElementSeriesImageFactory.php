<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;

/**
 * Class ElementSeriesImageFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesImageFactory
{
    /**
     * @param array $rawElementSeriesImage
     *
     * @return ElementSeriesImage
     */
    public function createFromRaw(
        array $rawElementSeriesImage
    ): ElementSeriesImage {
        return new ElementSeriesImage(
            $rawElementSeriesImage['imageUrl'],
            $rawElementSeriesImage['imageName']
        );
    }
}
