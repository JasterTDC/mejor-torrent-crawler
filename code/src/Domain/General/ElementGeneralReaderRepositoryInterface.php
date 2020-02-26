<?php

namespace BestThor\ScrappingMaster\Domain\General;

use BestThor\ScrappingMaster\Domain\General\ElementGeneral;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralCollectionEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralEmptyException;

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
    ): ElementGeneralCollection;

    /**
     * Get total pages
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Get ElementGeneral by the main identifier
     *
     * @param int $elementGeneralId
     *
     * @return ElementGeneral|null
     * @throws ElementGeneralEmptyException
     */
    public function getById(int $elementGeneralId): ?ElementGeneral;
}
