<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class GetElementGeneralCollectionUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralCollectionUseCaseResponse
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
     * GetElementGeneralCollectionUseCaseResponse constructor.
     *
     * @param bool $success
     */
    public function __construct(
        bool $success,
        ?string $error
    ) {
        $this->success = $success;
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
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
