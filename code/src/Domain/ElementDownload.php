<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Class ElementDownload
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDownload
{

    /**
     * @var string|null
     */
    protected $elementDownloadName;

    /**
     * @var string|null
     */
    protected $elementDownloadTorrentUrl;

    /**
     * ElementDownload constructor.
     *
     * @param string|null   $elementDownloadTorrentUrl
     * @param string|null   $elementDownloadName
     */
    public function __construct(
        ?string $elementDownloadTorrentUrl,
        ?string $elementDownloadName
    ) {
        $this->elementDownloadTorrentUrl    = $elementDownloadTorrentUrl;
        $this->elementDownloadName          = $elementDownloadName;
    }

    /**
     * @return string|null
     */
    public function getElementDownloadTorrentUrl(): ?string
    {
        return $this->elementDownloadTorrentUrl;
    }

    /**
     * @return string|null
     */
    public function getElementDownloadName(): ?string
    {
        return $this->elementDownloadName;
    }
}
