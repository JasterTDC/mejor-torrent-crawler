<?php

namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Interface TagReaderRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface TagWriterRepositoryInterface
{

    /**
     * @param Tag $tag
     *
     * @return Tag
     */
    public function persist(Tag $tag): Tag;
}
