<?php


namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Interface TagFactoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface TagFactoryInterface
{

    /**
     * @param array $rawTagCollection
     *
     * @return TagCollection
     */
    public function createTagCollectionFromRaw(
        array $rawTagCollection
    ) : TagCollection;

    /**
     * @param array $rawTag
     *
     * @return Tag
     */
    public function createTagFromRaw(
        array $rawTag
    ) : Tag;
}
