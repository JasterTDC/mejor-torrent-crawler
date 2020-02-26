<?php

namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDescription;

/**
 * Class ElementSeriesDescriptionDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDescriptionDataTransformer
{
    /**
     * @param ElementSeriesDescription $elementSeriesDescription
     *
     * @return string
     */
    public function transform(
        ElementSeriesDescription $elementSeriesDescription
    ): string {
        return $elementSeriesDescription->getDescription();
    }
}
