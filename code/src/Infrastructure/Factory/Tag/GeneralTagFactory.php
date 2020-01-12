<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory\Tag;

use BestThor\ScrappingMaster\Domain\Tag\GeneralTag;
use BestThor\ScrappingMaster\Domain\Tag\GeneralTagFactoryInterface;

/**
 * Class GeneralTagFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory\Tag
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralTagFactory implements GeneralTagFactoryInterface
{

    /**
     * @param array $rawGeneralTag
     *
     * @return GeneralTag
     */
    public function createFromRaw(array $rawGeneralTag): GeneralTag
    {
        $createdAt = new \DateTimeImmutable();
        $updatedAt = new \DateTimeImmutable();

        if (!empty($rawGeneralTag['createdAt'])) {
            $createdAt = \DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $rawGeneralTag['createdAt']
            );
        }

        if (!empty($rawGeneralTag['updatedAt'])) {
            $updatedAt = \DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $rawGeneralTag['updatedAt']
            );
        }

        return new GeneralTag(
            (int) $rawGeneralTag['generalId'],
            (int) $rawGeneralTag['tagId'],
            $createdAt,
            $updatedAt
        );
    }
}
