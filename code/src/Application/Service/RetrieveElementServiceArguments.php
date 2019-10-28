<?php


namespace BestThor\ScrappingMaster\Application\Service;

/**
 * Class RetrieveElementServiceArguments
 *
 * @package BestThor\ScrappingMaster\Application\Service
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementServiceArguments
{

    /**
     * @var int
     */
    protected $page;

    /**
     * RetrieveElementServiceArguments constructor.
     *
     * @param int $page
     */
    public function __construct(int $page)
    {
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
