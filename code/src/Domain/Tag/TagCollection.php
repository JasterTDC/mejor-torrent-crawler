<?php

namespace BestThor\ScrappingMaster\Domain\Tag;

use BestThor\ScrappingMaster\Domain\BaseCollection;

/**
 * Class TagCollection
 *
 * @package BestThor\ScrappingMaster\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagCollection extends BaseCollection
{
    /**
     * @param Tag $tag
     */
    public function add(Tag $tag): void
    {
        $this->addToCollection($tag, $tag->getId());
    }
}
