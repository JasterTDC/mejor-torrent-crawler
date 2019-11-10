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
     * @param string $name
     * @param string $link
     * @param ElementSeriesDownload|null $elementSeriesDownload
     */
    public function __construct(
        int $id,
        string $name,
        string $link,
        ?ElementSeriesDownload $elementSeriesDownload
    ) {
        $this->id = $id;
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
     *
     * @return ElementSeriesDetail
     */
    public function setElementSeriesDownload(
        ?ElementSeriesDownload $elementSeriesDownload
    ) : self {
        return new static(
            $this->id,
            $this->name,
            $this->link,
            $elementSeriesDownload
        );
    }
}
