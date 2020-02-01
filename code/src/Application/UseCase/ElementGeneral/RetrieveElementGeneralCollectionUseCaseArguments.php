<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * RetrieveElementGeneralCollectionUseCaseArguments class
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralCollectionUseCaseArguments
{

    /**
     * Page number
     *
     * @var int
     */
    protected $page;

    /**
     * Limit
     *
     * @var int
     */
    protected $limit;

    /**
     * RetrieveElementGeneralCollectionUseCaseArguments constructor
     *
     * @param int $page
     * @param int $limit
     */
    public function __construct(
        int $page,
        int $limit
    ) {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Get page number
     *
     * @return  int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get limit
     *
     * @return  int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
