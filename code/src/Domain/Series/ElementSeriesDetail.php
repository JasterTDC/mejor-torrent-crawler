<?php


namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Class ElementSeriesDetail
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetail
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int|null
     */
    protected $seriesId;

    /**
     * @var string
     */
    protected $name;

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
     * @var ElementSeriesDownload|null
     */
    protected $elementSeriesDownload;

    /**
     * ElementSeriesDetail constructor.
     *
     * @param int $id
     * @param int|null $seriesId
     * @param string $name
     * @param string $link
     * @param \DateTimeImmutable $createdAt
     * @param \DateTimeImmutable $updatedAt
     * @param ElementSeriesDownload|null $elementSeriesDownload
     */
    public function __construct(
        int $id,
        ?int $seriesId,
        string $name,
        string $link,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?ElementSeriesDownload $elementSeriesDownload
    ) {
        $this->id = $id;
        $this->seriesId = $seriesId;
        $this->name = $name;
        $this->link = $link;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->elementSeriesDownload = $elementSeriesDownload;
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
     * @return int|null
     */
    public function getSeriesId(): ?int
    {
        return $this->seriesId;
    }

    /**
     * @param int|null $seriesId
     */
    public function setSeriesId(?int $seriesId): void
    {
        $this->seriesId = $seriesId;
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
     * @return ElementSeriesDownload|null
     */
    public function getElementSeriesDownload(): ?ElementSeriesDownload
    {
        return $this->elementSeriesDownload;
    }

    /**
     * @param ElementSeriesDownload|null $elementSeriesDownload
     */
    public function setElementSeriesDownload(?ElementSeriesDownload $elementSeriesDownload): void
    {
        $this->elementSeriesDownload = $elementSeriesDownload;
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
