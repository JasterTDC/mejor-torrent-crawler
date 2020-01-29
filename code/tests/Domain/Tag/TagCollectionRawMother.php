<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Tag;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class TagCollectionRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagCollectionRawMother
{

    /**
     * @return array
     */
    public static function createWithOne(): array
    {
        $rawTagCollection = [];

        $rawTagCollection[] = TagRawMother::random();

        return $rawTagCollection;
    }

    /**
     * @return array
     */
    public static function create(): array
    {
        $rawTagCollection = [];

        $total = MotherCreator::random()->numberBetween(2, 15);

        for ($i = 0; $i < $total; $i++) {
            $rawTagCollection[] = TagRawMother::random();
        }

        return $rawTagCollection;
    }

    /**
     * @return array
     */
    public static function createEmpty(): array
    {
        return [];
    }
}
