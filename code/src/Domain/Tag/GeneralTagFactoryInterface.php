<?php


namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Interface GeneralTagFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface GeneralTagFactoryInterface
{

    /**
     * @param array $rawGeneralTag
     *
     * @return GeneralTag
     */
    public function createFromRaw(array $rawGeneralTag) : GeneralTag;
}
