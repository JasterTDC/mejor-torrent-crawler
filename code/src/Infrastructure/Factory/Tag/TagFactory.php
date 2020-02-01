<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory\Tag;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagCollection;
use BestThor\ScrappingMaster\Domain\Tag\TagFactoryInterface;

/**
 * Class TagFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagFactory implements TagFactoryInterface
{
    /**
     * @param array $rawTagCollection
     *
     * @return TagCollection
     */
    public function createTagCollectionFromRaw(
        array $rawTagCollection
    ): TagCollection {
        $tagCollection = new TagCollection();

        foreach ($rawTagCollection as $rawTag) {
            $tagCollection->add(
                $this->createTagFromRaw($rawTag)
            );
        }

        return $tagCollection;
    }

    /**
     * @param array $rawTag
     *
     * @return Tag
     */
    public function createTagFromRaw(
        array $rawTag
    ): Tag {
        $tagId = null;
        $tagName = null;
        $tagCreatedAt = null;
        $tagUpdatedAt = null;

        if (!empty($rawTag['name'])) {
            $tagName = $rawTag['name'];
        }

        if (!empty($rawTag['id'])) {
            $tagId = (int) $rawTag['id'];
        }

        if (!empty($rawTag['createdAt'])) {
            $tagCreatedAt = \DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $rawTag['createdAt']
            );
        }

        if (!empty($rawTag['updatedAt'])) {
            $tagUpdatedAt = \DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $rawTag['updatedAt']
            );
        }

        $tag = new Tag($tagName);

        $tag->setId($tagId);
        $tag->setName($tagName);

        if (!empty($tagCreatedAt)) {
            $tag->setCreatedAt($tagCreatedAt);
        }

        if (!empty($tagUpdatedAt)) {
            $tag->setUpdatedAt($tagUpdatedAt);
        }

        return $tag;
    }
}
