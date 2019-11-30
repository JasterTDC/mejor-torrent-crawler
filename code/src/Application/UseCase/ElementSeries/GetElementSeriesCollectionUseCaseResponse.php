<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;

/**
 * Class GetElementSeriesCollectionUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementSeriesCollectionUseCaseResponse
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var ElementSeriesCollection|null
     */
    protected $elementSeriesCollection;

    /**
     * @var array|null
     */
    protected $errorImage;

    /**
     * @var array|null
     */
    protected $errorFile;

    /**
     * GetElementSeriesCollectionUseCaseResponse constructor.
     *
     * @param bool $success
     * @param ElementSeriesCollection|null $elementSeriesCollection
     * @param array|null $errorImage
     * @param array|null $errorFile
     */
    public function __construct(
        bool $success,
        ?ElementSeriesCollection $elementSeriesCollection,
        ?array $errorImage,
        ?array $errorFile
    ) {
        $this->success = $success;
        $this->elementSeriesCollection = $elementSeriesCollection;
        $this->errorImage = $errorImage;
        $this->errorFile = $errorFile;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return ElementSeriesCollection|null
     */
    public function getElementSeriesCollection(): ?ElementSeriesCollection
    {
        return $this->elementSeriesCollection;
    }

    /**
     * @return array|null
     */
    public function getErrorImage(): ?array
    {
        return $this->errorImage;
    }

    /**
     * @return array|null
     */
    public function getErrorFile(): ?array
    {
        return $this->errorFile;
    }
}
