<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

/**
 * RetrieveElementSeriesCollectionUseCaseArguments
 * 
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementSeriesCollectionUseCaseArguments
{

    /**
     * Page number
     *
     * @var int
     */
    protected $page;

    /**
     * Series limit
     *
     * @var int
     */
    protected $limit;

    /**
     * RetrieveElementSeriesCollectionUseCaseArguments constructor
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
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get series limit
     *
     * @return  int
     */ 
    public function getLimit()
    {
        return $this->limit;
    }
}
