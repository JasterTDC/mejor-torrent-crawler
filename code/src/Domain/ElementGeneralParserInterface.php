<?php

namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementGeneralParserInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementGeneralParserInterface
{

    /**
     * @param string $content
     */
    public function setContent(string $content): void;

    /**
     * @return ElementGeneralCollection
     *
     * @throws ElementGeneralEmptyException
     */
    public function getElementGeneral(): ElementGeneralCollection;
}
