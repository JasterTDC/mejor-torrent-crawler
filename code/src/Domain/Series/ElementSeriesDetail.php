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
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
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
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
