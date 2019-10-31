<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;

/**
 * Class RetrieveElementGeneralUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralUseCaseResponse
{

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var ElementGeneralCollection|null
     */
    protected $elementGeneralCollection;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * RetrieveElementGeneralUseCaseResponse constructor.
     * @param bool $success
     * @param ElementGeneralCollection|null $elementGeneralCollection
     * @param string|null $error
     */
    public function __construct(
        bool $success,
        ?ElementGeneralCollection $elementGeneralCollection,
        ?string $error
    ) {
        $this->success = $success;
        $this->elementGeneralCollection = $elementGeneralCollection;
        $this->error = $error;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return ElementGeneralCollection|null
     */
    public function getElementGeneralCollection(): ?ElementGeneralCollection
    {
        return $this->elementGeneralCollection;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
