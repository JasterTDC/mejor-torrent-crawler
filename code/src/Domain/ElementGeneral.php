<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Class Element
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneral
{

    /**
     * @var int
     */
    protected $elementId;

    /**
     * @var string
     */
    protected $elementName;

    /**
     * @var string
     */
    protected $elementSlug;

    /**
     * @var string
     */
    protected $elementLink;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @var ElementDetail|null
     */
    protected $elementDetail;

    /**
     * @var ElementDownload|null
     */
    protected $elementDownload;

    /**
     * Element constructor.
     *
     * @param int $elementId
     * @param string $elementName
     * @param string $elementSlug
     * @param string $elementLink
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     * @param ElementDetail|null $elementDetail
     * @param ElementDownload|null $elementDownload
     */
    public function __construct(
        int $elementId,
        string $elementName,
        string $elementSlug,
        string $elementLink,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?ElementDetail $elementDetail,
        ?ElementDownload $elementDownload
    ) {
        $this->elementId = $elementId;
        $this->elementName = $elementName;
        $this->elementSlug = $elementSlug;
        $this->elementLink = $elementLink;
        $this->elementDetail = $elementDetail;
        $this->elementDownload = $elementDownload;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getElementId(): int
    {
        return $this->elementId;
    }

    /**
     * @param int $elementId
     */
    public function setElementId(int $elementId): void
    {
        $this->elementId = $elementId;
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return $this->elementName;
    }

    /**
     * @param string $elementName
     */
    public function setElementName(string $elementName): void
    {
        $this->elementName = $elementName;
    }

    /**
     * @return string
     */
    public function getElementSlug(): string
    {
        return $this->elementSlug;
    }

    /**
     * @param string $elementSlug
     */
    public function setElementSlug(string $elementSlug): void
    {
        $this->elementSlug = $elementSlug;
    }

    /**
     * @return string
     */
    public function getElementLink(): string
    {
        return $this->elementLink;
    }

    /**
     * @param string $elementLink
     */
    public function setElementLink(string $elementLink): void
    {
        $this->elementLink = $elementLink;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ElementDetail|null
     */
    public function getElementDetail(): ?ElementDetail
    {
        return $this->elementDetail;
    }

    /**
     * @param ElementDetail|null $elementDetail
     */
    public function setElementDetail(?ElementDetail $elementDetail): void
    {
        $this->elementDetail = $elementDetail;
    }

    /**
     * @return ElementDownload|null
     */
    public function getElementDownload(): ?ElementDownload
    {
        return $this->elementDownload;
    }

    /**
     * @param ElementDownload|null $elementDownload
     */
    public function setElementDownload(?ElementDownload $elementDownload): void
    {
        $this->elementDownload = $elementDownload;
    }
}
