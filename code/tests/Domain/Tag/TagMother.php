<?php


namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class TagMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagMother
{

    /**
     * @return Tag
     */
    public static function createTagWithoutId(): Tag
    {
        return new Tag(MotherCreator::random()->lastName);
    }
}
