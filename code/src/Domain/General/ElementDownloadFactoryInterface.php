<?php

namespace BestThor\ScrappingMaster\Domain\General;

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
     * @return ElementDownload|null
     */
    public function createFromRaw(
        array $rawElementDownload
    ): ?ElementDownload;
}
