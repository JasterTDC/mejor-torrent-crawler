<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

/**
 * Class SaveElementGeneralUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementGeneralUseCaseResponse
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
     * SaveElementGeneralUseCaseResponse constructor.
     * @param bool $success
     * @param string|null $error
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
