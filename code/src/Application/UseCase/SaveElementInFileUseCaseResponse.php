<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

/**
 * Class SaveElementInFileUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementInFileUseCaseResponse
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * SaveElementInFileUseCaseResponse constructor.
     * @param bool $success
     */
    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
