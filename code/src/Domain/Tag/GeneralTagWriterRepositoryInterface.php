<?php


namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Interface GeneralTagWriterRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface GeneralTagWriterRepositoryInterface
{

    /**
     * @param GeneralTag $generalTag
     *
     * @return bool
     */
    public function persist(GeneralTag $generalTag) : bool;
}
