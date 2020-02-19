<?php

namespace BestThor\ScrappingMaster\Domain\Series;

/**
 * Class ElementSeriesImage
 *
 * @package BestThor\ScrappingMaster\Domain\Series
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesImage
{

    /**
     * @var string
     */
    protected $imageUrl;

    /**
     * @var string
     */
    protected $imageName;

    /**
     * ElementSeriesImage constructor.
     *
     * @param string $imageUrl
     * @param string $imageName
     */
    public function __construct(
        string $imageUrl,
        string $imageName
    ) {
        $this->imageUrl = $imageUrl;
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageUrl
     *
     * @return ElementSeriesImage
     */
    public function setImageUrl(
        string $imageUrl
    ): self {
        return new static(
            $imageUrl,
            $this->imageName
        );
    }
}
