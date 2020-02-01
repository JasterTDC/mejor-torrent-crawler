<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

/**
 * Class GetElementGeneralCollectionArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralCollectionArguments
{

    /**
     * @var int
     */
    protected $totalPages;

    /**
     * GetElementGeneralCollectionArguments constructor.
     *
     * @param int $totalPages
     */
    public function __construct(
        int $totalPages
    ) {
        $this->totalPages = $totalPages;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }
}
