<?php

namespace BestThor\ScrappingMaster\Domain\General;

/**
 * Interface ElementDetailParserInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementDetailParserInterface
{

    /**
     * @param string $content
     */
    public function setContent(string $content): void;

    /**
     * @return ElementDetail
     */
    public function getElementDetail(): ElementDetail;
}
