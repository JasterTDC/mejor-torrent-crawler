<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;

/**
 * Class GetElementGeneralUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralUseCaseResponse
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * @var ElementGeneralCollection|null
     */
    protected $elementGeneralCollection;

    /**
     * GetElementGeneralUseCaseResponse constructor.
     *
     * @param bool $success
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
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @return ElementGeneralCollection|null
     */
    public function getElementGeneralCollection(): ?ElementGeneralCollection
    {
        return $this->elementGeneralCollection;
    }
}
