<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class GetElementGeneralUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralUseCaseArguments
{

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $page;

    /**
     * GetElementGeneralUseCaseArguments constructor.
     *
     * @param int $limit
     * @param int $page
     */
    public function __construct(
        int $limit,
        int $page
    ) {
        $this->limit = $limit;
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
