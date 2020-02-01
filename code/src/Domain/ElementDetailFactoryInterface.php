<?php

namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface ElementDetailFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface ElementDetailFactoryInterface
{

    /**
     * @param array $rawElementDetail
     *
     * @return ElementDetail
     */
    public function createElementDetailFromRaw(
        array $rawElementDetail
    ): ElementDetail;
}
