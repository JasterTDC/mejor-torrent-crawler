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
     * RetrieveElementGeneralCollectionUseCaseResponse constructor
     *
     * @param boolean $success
     * @param string|null $error
     * @param ElementGeneralCollection|null $elementGeneralCollection
     */
    public function __construct(
        bool $success,
        ?string $error,
        ?ElementGeneralCollection $elementGeneralCollection
    ) {
        $this->success = $success;
        $this->error = $error;
        $this->elementGeneralCollection = $elementGeneralCollection;
    }

    /**
     * Get it indicates if the operation was successful or ot
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
     * Get elementGeneralCollection
     *
     * @return  ElementGeneralCollection|null
     */ 
    public function getElementGeneralCollection()
    {
        return $this->elementGeneralCollection;
    }
}
