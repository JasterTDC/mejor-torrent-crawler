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
    protected $elementDownloadUrl;

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
     * @param string|null   $elementDownloadUrl
     * @param string|null   $elementDownloadTorrentUrl
     * @param string|null   $elementDownloadName
     */
    public function __construct(
        ?string $elementDownloadUrl,
        ?string $elementDownloadTorrentUrl,
        ?string $elementDownloadName
    ) {
        $this->elementDownloadUrl           = $elementDownloadUrl;
        $this->elementDownloadTorrentUrl    = $elementDownloadTorrentUrl;
        $this->elementDownloadName          = $elementDownloadName;
    }

    /**
     * @return string|null
     */
    public function getElementDownloadUrl(): ?string
    {
        return $this->elementDownloadUrl;
    }

    /**
     * @return string|null
     */
    public function getElementDownloadTorrentUrl(): ?string
    {
        return $this->elementDownloadTorrentUrl;
    }

    /**
     * @param string|null $elementDownloadUrl
     *
     * @return ElementDownload
     */
    public function setElementDownloadUrl(?string $elementDownloadUrl) : self
    {
        return new static(
            $elementDownloadUrl,
            $this->elementDownloadTorrentUrl,
            $this->elementDownloadName
        );
    }

    /**
     * @param string|null $elementDownloadTorrentUrl
     *
     * @return ElementDownload
     */
    public function setElementDownloadTorrentUrl(?string $elementDownloadTorrentUrl) : self
    {
        return new static(
            $this->elementDownloadUrl,
            $elementDownloadTorrentUrl,
            $this->elementDownloadName
        );
    }

    /**
     * @return string|null
     */
    public function getElementDownloadName(): ?string
    {
        return $this->elementDownloadName;
    }
}
