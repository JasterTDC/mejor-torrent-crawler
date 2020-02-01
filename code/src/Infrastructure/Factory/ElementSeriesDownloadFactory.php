<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDownload;

/**
 * Class ElementSeriesDownloadFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadFactory
{

    /**
     * @var string
     */
    protected $downloadUrl;

    /**
     * ElementSeriesDownloadFactory constructor.
     *
     * @param string $downloadUrl
     */
    public function __construct(
        string $downloadUrl
    ) {
        $this->downloadUrl = $downloadUrl;
    }

    /**
     * @param array $rawDownload
     *
     * @return ElementSeriesDownload
     */
    public function createFromRaw(
        array $rawDownload
    ): ElementSeriesDownload {
        return new ElementSeriesDownload(
            $rawDownload['name'],
            $this->downloadUrl . $rawDownload['name']
        );
    }
}
