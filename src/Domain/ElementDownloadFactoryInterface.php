<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementDownloadFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementDownloadFactoryInterface
{

    /**
     * @param array $rawElementDownload
     *
     * @return ElementDownload
     */
    public function createFromRaw(
        array $rawElementDownload
    ) : ElementDownload;
}
