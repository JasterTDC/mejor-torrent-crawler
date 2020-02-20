<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagCollection;
use BestThor\ScrappingMaster\Domain\Tag\TagCriteria;
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

    /**
     * @param TagCriteria $tagCriteria
     *
     * @return TagCollection|null
     * @throws TagSearchException
     */
    public function findAll(
        TagCriteria $tagCriteria
    ): ?TagCollection {
        $sql = 'SELECT
            `id`,
            `name`,
            `createdAt`,
            `updatedAt`
        FROM `elements`.`tag`
        %s
        ';

        $orderBy = '';

        if (
            !empty($tagCriteria->getOrderBy()) &&
            TagCriteria::ORDER_NAME === $tagCriteria->getOrderBy()
        ) {
            $orderBy = 'ORDER BY `name`';
        }

        if (
            !empty($tagCriteria->getOderType()) &&
            TagCriteria::ORDER_TYPE_ASC === $tagCriteria->getOderType()
        ) {
            $orderBy .= ' ASC';
        }

        $sql = sprintf(
            $sql,
            $orderBy
        );

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $statement->execute();

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            return $this
                ->tagFactory
                ->createTagCollectionFromRaw($result);
        } catch (\PDOException $e) {
            throw new TagSearchException(
                __CLASS__ . ' ' .
                __FUNCTION__ . $e->getMessage(),
                2
            );
        }
    }
}
