<?php


namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Class ElementSeriesDescription
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDescription
{

    /**
     * @var string
     */
    protected $description;

    /**
     * ElementSeriesDescription constructor.
     *
     * @param string $description
     */
    public function __construct(
        string $description
    ) {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return ElementSeriesDescription
     */
    public function setDescription(
        string $description
    ) : self {
        return new static(
            $description
        );
    }
}
