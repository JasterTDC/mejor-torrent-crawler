<?php


namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Class ElementSeries
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeries
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $firstEpId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @var ElementSeriesImage|null
     */
    protected $elementSeriesImage;

    /**
     * @var ElementSeriesDescription|null
     */
    protected $elementSeriesDescription;

    /**
     * @var ElementSeriesDetailCollection|null
     */
    protected $elementSeriesDetailCollection;

    /**
     * ElementSeries constructor.
     *
     * @param int $id
     * @param int $firstEpId
     * @param string $name
     * @param string $slug
     * @param string $link
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     * @param ElementSeriesImage|null $elementSeriesImage
     * @param ElementSeriesDescription|null $elementSeriesDescription
     * @param ElementSeriesDetailCollection|null $elementSeriesDetailCollection
     */
    public function __construct(
        int $id,
        int $firstEpId,
        string $name,
        string $slug,
        string $link,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?ElementSeriesImage $elementSeriesImage,
        ?ElementSeriesDescription $elementSeriesDescription,
        ?ElementSeriesDetailCollection $elementSeriesDetailCollection
    ) {
        $this->id = $id;
        $this->firstEpId = $firstEpId;
        $this->name = $name;
        $this->slug = $slug;
        $this->link = $link;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->elementSeriesImage = $elementSeriesImage;
        $this->elementSeriesDescription = $elementSeriesDescription;
        $this->elementSeriesDetailCollection = $elementSeriesDetailCollection;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getFirstEpId(): int
    {
        return $this->firstEpId;
    }

    /**
     * @param int $firstEpId
     */
    public function setFirstEpId(int $firstEpId): void
    {
        $this->firstEpId = $firstEpId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return ElementSeriesImage|null
     */
    public function getElementSeriesImage(): ?ElementSeriesImage
    {
        return $this->elementSeriesImage;
    }

    /**
     * @param ElementSeriesImage|null $elementSeriesImage
     */
    public function setElementSeriesImage(?ElementSeriesImage $elementSeriesImage): void
    {
        $this->elementSeriesImage = $elementSeriesImage;
    }

    /**
     * @return ElementSeriesDescription|null
     */
    public function getElementSeriesDescription(): ?ElementSeriesDescription
    {
        return $this->elementSeriesDescription;
    }

    /**
     * @param ElementSeriesDescription|null $elementSeriesDescription
     */
    public function setElementSeriesDescription(?ElementSeriesDescription $elementSeriesDescription): void
    {
        $this->elementSeriesDescription = $elementSeriesDescription;
    }

    /**
     * @return ElementSeriesDetailCollection|null
     */
    public function getElementSeriesDetailCollection(): ?ElementSeriesDetailCollection
    {
        return $this->elementSeriesDetailCollection;
    }

    /**
     * @param ElementSeriesDetailCollection|null $elementSeriesDetailCollection
     */
    public function setElementSeriesDetailCollection(
        ?ElementSeriesDetailCollection $elementSeriesDetailCollection
    ): void {
        $this->elementSeriesDetailCollection = $elementSeriesDetailCollection;
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
}
