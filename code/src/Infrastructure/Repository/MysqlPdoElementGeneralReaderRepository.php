<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\General\ElementGeneral;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralEmptyException;
use PDOException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralTotalException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralFactoryInterface;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralCollectionEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralReaderRepositoryInterface;

/**
 * Class MysqlPdoElementGeneralReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralReaderRepository implements ElementGeneralReaderRepositoryInterface
{
    /**
     * @var PdoAccess
     */
    protected $pdoAccess;

    /**
     * @var ElementGeneralFactoryInterface
     */
    protected $elementGeneralFactory;

    /**
     * MysqlPdoElementGeneralReaderRepository constructor.
     * @param PdoAccess $pdoAccess
     *
     * @param ElementGeneralFactoryInterface $elementGeneralFactory
     */
    public function __construct(
        PdoAccess $pdoAccess,
        ElementGeneralFactoryInterface $elementGeneralFactory
    ) {
        $this->pdoAccess = $pdoAccess;
        $this->elementGeneralFactory = $elementGeneralFactory;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return ElementGeneralCollection
     * @throws ElementGeneralCollectionEmptyException
     */
    public function getElementGeneralByPage(
        int $page,
        int $limit
    ): ElementGeneralCollection {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT *
        FROM
            `elements`.`general`
        ORDER BY `createdAt` DESC
        LIMIT :offset, :limit
        ";

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $result = $statement->execute([
                'limit'     => $limit,
                'offset'    => $offset
            ]);

            if (empty($result)) {
                throw new ElementGeneralCollectionEmptyException(
                    'An error has been occurred while parameters processing',
                    2
                );
            }

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                throw new ElementGeneralCollectionEmptyException(
                    'We could not find any element general collection',
                    3
                );
            }

            return $this
                ->elementGeneralFactory
                ->createFromRawElementGeneralCollection($result);
        } catch (\PDOException $e) {
            throw new ElementGeneralCollectionEmptyException(
                'An error has been occurred with database',
                1
            );
        }
    }

    /**
     * Get total pages
     *
     * @return int
     */
    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) as total
        FROM `elements`.`general`";

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $result = $statement->execute();

            if (empty($result)) {
                throw new ElementGeneralTotalException(
                    __FUNCTION__ . ' We could not get total',
                    1
                );
            }

            $total = $statement->fetchAll();

            if (empty($total)) {
                return 0;
            }

            return (int) $total[0]['total'];
        } catch (PDOException $e) {
            throw new ElementGeneralTotalException(
                __FUNCTION__ . ' We could not get total',
                2
            );
        }
    }

    /**
     * Get ElementGeneral by the main identifier
     *
     * @param int $elementGeneralId
     *
     * @return ElementGeneral|null
     * @throws ElementGeneralEmptyException
     */
    public function getById(int $elementGeneralId): ?ElementGeneral
    {
        $sql = "SELECT *
        FROM `elements`.`general`
        WHERE `id` = :elementGeneralId
        ";

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            $result = $statement->execute([
                'elementGeneralId' => $elementGeneralId
            ]);

            if (empty($result)) {
                return null;
            }

            $assocResult = $statement->fetch(\PDO::FETCH_ASSOC);

            return $this
                ->elementGeneralFactory
                ->createFromRawElementGeneral($assocResult);
        } catch (PDOException $e) {
            throw new ElementGeneralEmptyException(
                __FUNCTION__ . ' We could not get the element general',
                2
            );
        }
    }
}
