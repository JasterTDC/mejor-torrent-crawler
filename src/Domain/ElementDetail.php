<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Class ElementDetail
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetail
{

    /**
     * @var \DateTimeImmutable|null
     */
    protected $elementPublishedDate;

    /**
     * @var string|null
     */
    protected $elementGenre;

    /**
     * @var string|null
     */
    protected $elementFormat;

    /**
     * @var string|null
     */
    protected $elementDescription;

    /**
     * @var string|null
     */
    protected $elementCoverImg;

    /**
     * @var string|null
     */
    protected $elementCoverImgName;

    /**
     * @var string|null
     */
    protected $elementDownloadLink;

    /**
     * @var string|null
     */
    protected $elementDir;

    /**
     * @var string|null
     */
    protected $elementYearDir;

    /**
     * @var string|null
     */
    protected $elementMonthDir;

    /**
     * ElementDetail constructor.
     * @param \DateTimeImmutable|null $elementPublishedDate
     * @param string|null $elementGenre
     * @param string|null $elementFormat
     * @param string|null $elementDescription
     * @param string|null $elementCoverImg
     * @param string|null $elementCoverImgName
     * @param string|null $elementDownloadLink
     * @param string|null $elementDir
     * @param string|null $elementYearDir
     * @param string|null $elementMonthDir
     */
    public function __construct(
        ?\DateTimeImmutable $elementPublishedDate,
        ?string $elementGenre,
        ?string $elementFormat,
        ?string $elementDescription,
        ?string $elementCoverImg,
        ?string $elementCoverImgName,
        ?string $elementDownloadLink,
        ?string $elementDir,
        ?string $elementYearDir,
        ?string $elementMonthDir
    ) {
        $this->elementPublishedDate = $elementPublishedDate;
        $this->elementGenre = $elementGenre;
        $this->elementFormat = $elementFormat;
        $this->elementDescription = $elementDescription;
        $this->elementCoverImg = $elementCoverImg;
        $this->elementCoverImgName = $elementCoverImgName;
        $this->elementDownloadLink = $elementDownloadLink;
        $this->elementDir = $elementDir;
        $this->elementYearDir = $elementYearDir;
        $this->elementMonthDir = $elementMonthDir;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getElementPublishedDate(): ?\DateTimeImmutable
    {
        return $this->elementPublishedDate;
    }

    /**
     * @return string|null
     */
    public function getElementGenre(): ?string
    {
        return $this->elementGenre;
    }

    /**
     * @return string|null
     */
    public function getElementFormat(): ?string
    {
        return $this->elementFormat;
    }

    /**
     * @return string|null
     */
    public function getElementDescription(): ?string
    {
        return $this->elementDescription;
    }

    /**
     * @return string|null
     */
    public function getElementCoverImg(): ?string
    {
        return $this->elementCoverImg;
    }

    /**
     * @return string|null
     */
    public function getElementCoverImgName(): ?string
    {
        return $this->elementCoverImgName;
    }

    /**
     * @return string|null
     */
    public function getElementDownloadLink(): ?string
    {
        return $this->elementDownloadLink;
    }

    /**
     * @return string|null
     */
    public function getElementDir(): ?string
    {
        return $this->elementDir;
    }

    /**
     * @return string|null
     */
    public function getElementYearDir(): ?string
    {
        return $this->elementYearDir;
    }

    /**
     * @return string|null
     */
    public function getElementMonthDir(): ?string
    {
        return $this->elementMonthDir;
    }
}