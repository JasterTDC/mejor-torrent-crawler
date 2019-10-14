<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

/**
 * Class RetrieveElementGeneralUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralUseCaseArguments
{

    /**
     * @var string|null
     */
    protected $content;

    /**
     * RetrieveElementGeneralUseCaseArguments constructor.
     *
     * @param string|null $content
     */
    public function __construct(?string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}
