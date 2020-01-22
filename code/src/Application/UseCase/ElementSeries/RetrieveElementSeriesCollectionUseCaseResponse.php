<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;

/**
 * RetrieveElementSeriesColectionUseCaseResponse
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementSeriesCollectionUseCaseResponse
{

    /**
     * Success
     *
     * @var bool
     */
    protected $success;

    /**
     * Error message
     *
     * @var string|null
     */
    protected $error;
    
    /**
     * ElementSeriesCollection
     *
     * @var ElementSeriesCollection|null
     */
    protected $elementSeriesCollection;

    /**
     * Next page
     *
     * @var int|null
     */
    protected $nextPage;

    /**
     * Previous page
     *
     * @var int|null
     */
    protected $previousPage;

    /**
     * RetrieveElementSeriesColectionUseCaseResponse constructor
     *
     * @param boolean $success
     * @param ElementSeriesCollection|null $elementSeriesCollection
     * @param integer|null $previousPage
     * @param integer|null $nextPage
     * @param string|null $error
     */
    public function __construct(
        bool $success,
        ?ElementSeriesCollection $elementSeriesCollection,
        ?int $previousPage,
        ?int $nextPage,
        ?string $error
    ) {
        $this->success = $success;
        $this->elementSeriesCollection = $elementSeriesCollection;
        $this->previousPage = $previousPage;
        $this->nextPage = $nextPage;
        $this->error = $error;
    }

    /**
     * Get success
     *
     * @return  bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Get error message
     *
     * @return  string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get elementSeriesCollection
     *
     * @return  ElementSeriesCollection|null
     */
    public function getElementSeriesCollection()
    {
        return $this->elementSeriesCollection;
    }

    /**
     * Get next page
     *
     * @return  int|null
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * Get previous page
     *
     * @return  int|null
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }
}
