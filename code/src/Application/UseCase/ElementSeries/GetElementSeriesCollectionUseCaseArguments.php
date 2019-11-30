<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

/**
 * Class GetElementSeriesCollectionUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementSeriesCollectionUseCaseArguments
{
    /**
     * @var int
     */
    protected $page;

    /**
     * GetElementSeriesCollectionUseCaseArguments constructor.
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
