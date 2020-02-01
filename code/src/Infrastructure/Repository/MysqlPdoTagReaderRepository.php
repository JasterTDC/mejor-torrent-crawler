<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagFactoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Tag\TagSearchException;

/**
 * Class MysqlPdoTagReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoTagReaderRepository implements TagReaderRepositoryInterface
{

    /**
     * @var PdoAccess
     */
    protected $pdoAccess;

    /**
     * @var TagFactoryInterface
     */
    protected $tagFactory;

    /**
     * MysqlPdoTagReaderRepository constructor.
     *
     * @param PdoAccess $pdoAccess
     * @param TagFactoryInterface $tagFactory
     */
    public function __construct(
        PdoAccess $pdoAccess,
        TagFactoryInterface $tagFactory
    ) {
        $this->pdoAccess = $pdoAccess;
        $this->tagFactory = $tagFactory;
    }

    /**
     * @param string $name
     *
     * @return Tag|null
     * @throws TagSearchException
     */
    public function findByName(
        string $name
    ): ?Tag {
        $sql = 'SELECT
            `id`,
            `name`,
            `createdAt`,
            `updatedAt`
        FROM `elements`.`tag`
        WHERE
            `name` = :name
        ';

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $statement->execute([
                'name'  => $name
            ]);

            $result = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($result === (array) $result) {
                return $this
                    ->tagFactory
                    ->createTagFromRaw($result);
            }

            return null;
        } catch (\PDOException $e) {
            throw new TagSearchException(
                'TagSearchException ' . $e->getMessage(),
                2
            );
        }
    }
}
