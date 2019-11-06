<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class RetrieveElementGeneralContentUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralContentUseCaseResponse
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * RetrieveElementGeneralContentUseCaseResponse constructor.
     *
     * @param bool $success
     * @param string|null $content
     * @param string|null $error
     */
    public function __construct(
        bool $success,
        ?string $content,
        ?string $error
    ) {
        $this->success = $success;
        $this->content = $content;
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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
