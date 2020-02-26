<?php

namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDownload;

/**
 * Class ElementSeriesDownloadDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadDataTransformer
{
    /**
     * @param ElementSeriesDownload $elementSeriesDownload
     *
     * @return array
     */
    public function transform(
        ElementSeriesDownload $elementSeriesDownload
    ): array {
        return [
            'name'  => $elementSeriesDownload->getDownloadName(),
            'link'  => $elementSeriesDownload->getDownloadLink()
        ];
    }
}
