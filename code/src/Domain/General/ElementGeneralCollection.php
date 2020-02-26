<?php

namespace BestThor\ScrappingMaster\Domain\General;

use BestThor\ScrappingMaster\Domain\Shared\BaseCollection;

/**
 * Class ElementGeneralCollection
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralCollection extends BaseCollection
{

    /**
     * @param ElementGeneral $elementGeneral
     */
    public function add(ElementGeneral $elementGeneral): void
    {
        $this->addToCollection(
            $elementGeneral,
            $elementGeneral->getElementId()
        );
    }
}
