<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\General\ElementGeneral;

/**
 * Class GetElementGeneralDetailResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralDetailResponse
{

    /**
     * It indicates if the response was successful
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
     * ElementGeneral detail
     *
     * @var ElementGeneral|null
     */
    protected $elementGeneral;

    /**
     * GetElementGeneralDetailResponse constructor.
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
