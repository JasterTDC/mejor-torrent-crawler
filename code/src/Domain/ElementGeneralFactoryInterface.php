<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementGeneralFactoryInterface
{

    /**
     * @param array $rawElementGeneral
     *
     * @return ElementGeneral
     */
    public function createFromRawElementGeneral(
        array $rawElementGeneral
    ) : ElementGeneral;

    /**
     * @param array $rawElementGeneralCollection
     *
     * @return ElementGeneralCollection
     */
    public function createFromRawElementGeneralCollection(
        array $rawElementGeneralCollection
    ) : ElementGeneralCollection;
}
