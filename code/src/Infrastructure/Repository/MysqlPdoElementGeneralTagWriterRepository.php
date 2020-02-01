<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\GeneralTag;
use BestThor\ScrappingMaster\Domain\Tag\GeneralTagSaveException;
use BestThor\ScrappingMaster\Domain\Tag\GeneralTagWriterRepositoryInterface;

/**
 * Class MysqlPdoElementGeneralTagWriterRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralTagWriterRepository implements GeneralTagWriterRepositoryInterface
{

    /**
     * @var PdoAccess
     */
    protected $pdoAccess;

    /**
     * MysqlPdoElementGeneralTagWriterRepository constructor.
     * @param PdoAccess $pdoAccess
     */
    public function __construct(PdoAccess $pdoAccess)
    {
        $this->pdoAccess = $pdoAccess;
    }

    /**
     * @param GeneralTag $generalTag
     *
     * @return bool
     * @throws GeneralTagSaveException
     */
    public function persist(GeneralTag $generalTag): bool
    {
        $sql = 'INSERT INTO `elements`.`general_tag`(
            `generalId`,
            `tagId`,
            `createdAt`,
            `updatedAt`
        ) VALUES (
            :generalId,
            :tagId,
            :createdAt,
            :updatedAt
        ) ON DUPLICATE KEY UPDATE `updatedAt` = VALUES(`updatedAt`)
        ';

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $parameters = [
                'generalId'     => $generalTag->getGeneralId(),
                'tagId'         => $generalTag->getTagId(),
                'createdAt'     => $generalTag->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt'     => $generalTag->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            return $statement->execute($parameters);
        } catch (\PDOException $e) {
            throw new GeneralTagSaveException(
                'GeneralTagPersist ' . $e->getMessage(),
                2
            );
        }
    }
}
