<?php

namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagCollection;

/**
 * Class GetTagDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagDataTransformer
{
    protected const ID = 'id';
    protected const NAME = 'name';
    protected const COLLECTION = 'tagCollection';
    protected const TAG_ACTIVE = 'tagActive';

    /**
     * @param TagCollection $tagCollection
     *
     * @return array
     */
    public function transform(
        TagCollection $tagCollection
    ): array {
        $collection = [];
        $ret = [];

        /** @var Tag $tag */
        foreach ($tagCollection as $tag) {
            $collection[] = [
                self::ID => $tag->getId(),
                self::NAME => $tag->getName()
            ];
        }

        $ret[self::COLLECTION] = $collection;
        $ret[self::TAG_ACTIVE] = true;

        return $ret;
    }
}
