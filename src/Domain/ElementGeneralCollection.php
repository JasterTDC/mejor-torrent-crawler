<?php


namespace BestThor\ScrappingMaster\Domain;

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
    public function add(ElementGeneral $elementGeneral)
    {
        $this->addToCollection(
            $elementGeneral,
            $elementGeneral->getElementId()
        );
    }
}
