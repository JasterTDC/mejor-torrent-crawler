<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollectionEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralFactoryInterface;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;

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
    ) : ElementGeneralCollection {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT *
        FROM
            `elements`.`general`
        LIMIT :offset, :limit
        ";

        try {
            $statement = $this
                ->pdoAccess
                ->getPdo()
                ->prepare($sql);

            if (empty($statement)) {
                throw new ElementGeneralCollectionEmptyException(
                    'An error has been occurred processing this request',
                    0
                );
            }

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
}