<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\Tag;
use BestThor\ScrappingMaster\Domain\Tag\TagSaveException;
use BestThor\ScrappingMaster\Domain\Tag\TagWriterRepositoryInterface;

/**
 * Class MysqlPdoTagWriterRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoTagWriterRepository implements TagWriterRepositoryInterface
{

    /**
     * @var PdoAccess
     */
    protected $pdoWriter;

    /**
     * MysqlPdoTagWriterRepository constructor.
     *
     * @param PdoAccess $pdoWriter
     */
    public function __construct(PdoAccess $pdoWriter)
    {
        $this->pdoWriter = $pdoWriter;
    }

    /**
     * @param Tag $tag
     *
     * @return Tag
     * @throws TagSaveException
     */
    public function persist(Tag $tag) : Tag
    {
        $sql = 'INSERT INTO `elements`.`tag` (
            `id`,
            `name`,
            `createdAt`,
            `updatedAt`
        ) VALUES (
            :id,
            :name,
            :createdAt,
            :updatedAt
        ) ON DUPLICATE KEY UPDATE `updatedAt` = VALUES(`updatedAt`)';

        try {
            $statement = $this
                ->pdoWriter
                ->getPdo()
                ->prepare($sql);

            $statement->execute([
                'id'        => $tag->getId(),
                'name'      => $tag->getName(),
                'createdAt' => $tag->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $tag->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            $tag->setId($this->pdoWriter->getPdo()->lastInsertId());

            return $tag;
        } catch (\PDOException $e) {
            throw new TagSaveException(
                'TagWriterRepository ' . __FUNCTION__ . $e->getMessage(),
                2
            );
        }
    }
}
