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
     * @param ElementSeriesDownload|null $elementSeriesDownload
     */
    public function __construct(
        int $id,
        ?int $seriesId,
        string $name,
        string $link,
        ?ElementSeriesDownload $elementSeriesDownload
    ) {
        $this->id = $id;
        $this->seriesId = $seriesId;
        $this->name = $name;
        $this->link = $link;
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
}
