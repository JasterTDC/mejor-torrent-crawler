<?php

namespace BestThor\ScrappingMaster\Domain\General;

use BestThor\ScrappingMaster\Domain\General\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralEmptyException;

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
    ): ElementGeneralCollection;
}
