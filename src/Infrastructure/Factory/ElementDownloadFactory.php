<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory;

use BestThor\ScrappingMaster\Domain\ElementDownload;
use BestThor\ScrappingMaster\Domain\ElementDownloadFactoryInterface;

/**
 * Class ElementDownloadFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDownloadFactory implements ElementDownloadFactoryInterface
{

    /**
     * @var string
     */
    protected $elementDownloadTorrentUrl;

    /**
     * ElementDownloadFactory constructor.
     *
     * @param string $elementDownloadTorrentUrl
     */
    public function __construct(
        string $elementDownloadTorrentUrl
    ) {
        $this->elementDownloadTorrentUrl = $elementDownloadTorrentUrl;
    }

    /**
     * @param array $rawElementDownload
     *
     * @return ElementDownload
     */
    public function createFromRaw(
        array $rawElementDownload
    ) : ElementDownload {
        $downloadTorrentName = null;

        if (!empty($rawElementDownload['elementDownloadName'])) {
            $downloadTorrentName = $this->elementDownloadTorrentUrl .
                $rawElementDownload['elementDownloadName'];
        }

        return new ElementDownload(
            null,
            $downloadTorrentName
        );
    }
}
