<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Class ElementSeriesDownload
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownload
{

    /**
     * @var string
     */
    protected $downloadName;

    /**
     * @var string|null
     */
    protected $downloadLink;

    /**
     * ElementSeriesDownload constructor.
     *
     * @param string $downloadName
     * @param string|null $downloadLink
     */
    public function __construct(
        string $downloadName,
        ?string $downloadLink
    ) {
        $this->downloadName = $downloadName;
        $this->downloadLink = $downloadLink;
    }

    /**
     * @return string
     */
    public function getDownloadName(): string
    {
        return $this->downloadName;
    }

    /**
     * @return string|null
     */
    public function getDownloadLink(): ?string
    {
        return $this->downloadLink;
    }

    /**
     * @param string $downloadName
     *
     * @return ElementSeriesDownload
     */
    public function setDownloadName(
        string $downloadName
    ): self {
        return new static(
            $downloadName,
            $this->downloadLink
        );
    }

    /**
     * @param string|null $downloadLink
     *
     * @return ElementSeriesDownload
     */
    public function setDownloadLink(
        ?string $downloadLink
    ): self {
        return new static(
            $this->downloadName,
            $downloadLink
        );
    }
}
