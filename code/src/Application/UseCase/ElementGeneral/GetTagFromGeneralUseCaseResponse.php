<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class GetTagFromGeneralUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagFromGeneralUseCaseResponse
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
     * GetTagFromGeneralUseCaseResponse constructor.
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

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param string|null $error
     */
    public function setError(?string $error): void
    {
        $this->error = $error;
    }
}
