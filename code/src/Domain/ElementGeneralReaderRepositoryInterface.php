<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementGeneralReaderRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementGeneralReaderRepositoryInterface
{

    /**
     * @param int $page
     * @param int $limit
     *
     * @return ElementGeneralCollection
     * @throws ElementGeneralCollectionEmptyException
     */
    public function getElementGeneralByPage(
        int $page,
        int $limit
    ) : ElementGeneralCollection;

    /**
     * Get total pages
     *
     * @return int
     */
    public function getTotal() : int;
}
