<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDetail;

use BestThor\ScrappingMaster\Domain\ElementGeneral;

/**
 * Class RetrieveElementDetailUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDetailUseCaseResponse
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
     * @var ElementGeneral|null
     */
    protected $elementGeneral;

    /**
     * RetrieveElementDetailUseCaseResponse constructor.
     *
     * @param bool $success
     * @param string|null $error
     * @param ElementGeneral|null $elementGeneral
     */
    public function __construct(
        bool $success,
        ?string $error,
        ?ElementGeneral $elementGeneral
    ) {
        $this->success = $success;
        $this->error = $error;
        $this->elementGeneral = $elementGeneral;
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
     * @return ElementGeneral|null
     */
    public function getElementGeneral(): ?ElementGeneral
    {
        return $this->elementGeneral;
    }
}
