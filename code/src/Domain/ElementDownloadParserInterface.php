<?php

namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementDownloadParserInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementDownloadParserInterface
{

    /**
     * @param string $content
     */
    public function setContent(
        string $content
    );

    /**
     * @return ElementDownload
     */
    public function getElementDownload(): ElementDownload;
}
