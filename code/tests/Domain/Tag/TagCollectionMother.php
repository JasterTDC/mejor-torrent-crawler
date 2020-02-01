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
        $tagCollection = new TagCollection();

        $total = MotherCreator::random()->numberBetween(2, 15);

        for($i = 0; $i < $total; $i++) {
            $tagCollection->add(
                TagMother::createTagWithoutId()
            );
        }

        return $tagCollection;
    }
}
