<?php


namespace BestThor\ScrappingMaster\Domain\Tag;

/**
 * Interface TagReaderRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface TagReaderRepositoryInterface
{

    /**
     * @param string $name
     *
     * @return Tag|null
     * @throws TagSearchException
     */
    public function findByName(
        string $name
    ) : ?Tag;
}
