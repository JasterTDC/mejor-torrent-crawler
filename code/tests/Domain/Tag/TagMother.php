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
    protected const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return Tag
     */
    public static function createTagWithoutId(): Tag
    {
        return new Tag(MotherCreator::random()->lastName);
    }

    /**
     * @return Tag
     */
    public static function create(): Tag
    {
        $dateCreated = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeThisCentury
        );

        $dateModified = \DateTimeImmutable::createFromMutable(
            MotherCreator::random()->dateTimeBetween(
                $dateCreated->format(self::DATE_FORMAT)
            )
        );

        $tag = new Tag(
            MotherCreator::random()->word
        );

        $tag->setId(MotherCreator::random()->numberBetween(1));
        $tag->setCreatedAt($dateCreated);
        $tag->setUpdatedAt($dateModified);

        return $tag;
    }
}
