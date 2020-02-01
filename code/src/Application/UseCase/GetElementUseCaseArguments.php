<?php

namespace BestThor\ScrappingMaster\Application\UseCase;

/**
 * Class GetElementUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementUseCaseArguments
{

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $limit;

    /**
     * GetElementUseCaseArguments constructor.
     * @param int $page
     * @param int $limit
     */
    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
