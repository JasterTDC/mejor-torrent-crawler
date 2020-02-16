<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Domain\Tag\TagCollection;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class TagCollectionMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagCollectionMother
{

    /**
     * @return TagCollection
     */
    public static function random(): TagCollection
    {
        $totalTags = MotherCreator::random()->numberBetween(2, 40);

        $tagCollection = new TagCollection();

        for ($i = 0; $i < $totalTags; $i++) {
            $tagCollection->add(
                TagMother::create()
            );
        }

        return $tagCollection;
    }
}
