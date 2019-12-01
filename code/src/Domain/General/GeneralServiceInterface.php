<?php


namespace BestThor\ScrappingMaster\Domain\General;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralEmptyException;

/**
 * Interface GeneralServiceInterface
 *
 * @package BestThor\ScrappingMaster\Domain\General
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface GeneralServiceInterface
{

    /**
     * @param int $page
     *
     * @return ElementGeneralCollection
     * @throws ElementGeneralContentEmptyException
     * @throws ElementGeneralEmptyException
     */
    public function getElementGeneralByPage(
        int $page
    ) : ElementGeneralCollection;
}
