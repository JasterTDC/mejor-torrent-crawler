<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesImage;

/**
 * Class ElementSeriesImageDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>1
 */
final class ElementSeriesImageDataTransformer
{
    /**
     * @param ElementSeriesImage $elementSeriesImage
     *
     * @return array
     */
    public function transform(
        ElementSeriesImage $elementSeriesImage
    ) : array {
        return [
            'imageUrl'  => $elementSeriesImage->getImageUrl(),
            'imageName' => $elementSeriesImage->getImageName()
        ];
    }
}
