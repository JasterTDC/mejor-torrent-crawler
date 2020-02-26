<?php

namespace BestThor\ScrappingMaster\Domain\General;

use BestThor\ScrappingMaster\Domain\General\ElementGeneralPersistException;

/**
 * Interface ElementGeneralReaderRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementGeneralWriterRepositoryInterface
{

    /**
     * @param ElementGeneral $elementGeneral
     *
     * @return bool
     * @throws ElementGeneralPersistException
     */
    public function persist(ElementGeneral $elementGeneral): bool;
}
