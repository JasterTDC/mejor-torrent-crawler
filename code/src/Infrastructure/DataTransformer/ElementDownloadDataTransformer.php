<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\ElementDownload;

/**
 * Class ElementDownloadDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDownloadDataTransformer
{

    /**
     * @param ElementDownload|null $elementDownload
     *
     * @return array
     */
    public function transform(
        ?ElementDownload $elementDownload
    ) : array {
        $ret = [];

        if (empty($elementDownload)) {
            return $ret;
        }
        
        if (!empty($elementDownload->getElementDownloadTorrentUrl())) {
            $ret['downloadThorUrl'] = $elementDownload->getElementDownloadTorrentUrl();
        }

        if (!empty($elementDownload->getElementDownloadName())) {
            $ret['downloadName'] = $elementDownload->getElementDownloadName();
        }

        return $ret;
    }
}
