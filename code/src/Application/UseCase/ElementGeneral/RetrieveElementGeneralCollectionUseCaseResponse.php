<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;

/**
 * RetrieveElementGeneralCollectionUseCaseResponse
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralCollectionUseCaseResponse
{

    /**
     * It indicates if the operation was successful or ot
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
     * ElementGeneralCollection
     *
     * @var ElementGeneralCollection|null
     */
    protected $elementGeneralCollection;

    /**
     * Total
     *
     * @var int|null
     */
    protected $total;

    /**
     * Previous page
     *
     * @var int|null
     */
    protected $previousPage;

    /**
     * Next page
     *
     * @var int|null
     */
    protected $nextPage;

    /**
     * RetrieveElementGeneralCollectionUseCaseResponse constructor
     *
     * @param boolean $success
     * @param string|null $error
     * @param int|null $total
     * @param int|null $previousPage
     * @param int|null $nextPage
     * @param ElementGeneralCollection|null $elementGeneralCollection
     */
    public function __construct(
        bool $success,
        ?string $error,
        ?int $total,
        ?int $previousPage,
        ?int $nextPage,
        ?ElementGeneralCollection $elementGeneralCollection
    ) {
        $this->success = $success;
        $this->error = $error;
        $this->total = $total;
        $this->previousPage = $previousPage;
        $this->nextPage = $nextPage;
        $this->elementGeneralCollection = $elementGeneralCollection;
    }

    /**
     * Get it indicates if the operation was successful or ot
     *
     * @return  bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Get error message
     *
     * @return  string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Get elementGeneralCollection
     *
     * @return  ElementGeneralCollection|null
     */
    public function getElementGeneralCollection(): ?ElementGeneralCollection
    {
        return $this->elementGeneralCollection;
    }

    /**
     * Get total
     *
     * @return  int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * Get previous page
     *
     * @return  int|null
     */
    public function getPreviousPage(): ?int
    {
        return $this->previousPage;
    }

    /**
     * Get next page
     *
     * @return  int|null
     */
    public function getNextPage(): ?int
    {
        return $this->nextPage;
    }
}
