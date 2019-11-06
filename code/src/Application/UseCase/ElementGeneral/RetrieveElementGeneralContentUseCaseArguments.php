<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class RetrieveElementGeneralContentUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralContentUseCaseArguments
{

    /**
     * @var int
     */
    protected $page;

    /**
     * RetrieveElementGeneralContentUseCaseArguments constructor.
     *
     * @param int $page
     */
    public function __construct(
        int $page
    ) {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
