<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesFactoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesReaderInterface;
use BestThor\ScrappingMaster\Domain\Series\TotalElementSeriesException;

/**
 * Class MysqlPdoElementSeriesReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesReaderRepository implements ElementSeriesReaderInterface
{
    /**
     * @var ElementSeriesFactoryInterface
     */
    protected $elementSeriesFactory;

    /**
     * @var PdoAccess
     */
    protected $pdoReader;

    /**
     * MysqlPdoElementSeriesReaderRepository constructor.
     *
     * @param ElementSeriesFactoryInterface $elementSeriesFactory
     * @param PdoAccess $pdoReader
     */
    public function __construct(
        ElementSeriesFactoryInterface $elementSeriesFactory,
        PdoAccess $pdoReader
    ) {
        $this->elementSeriesFactory = $elementSeriesFactory;
        $this->pdoReader = $pdoReader;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return ElementSeriesCollection
     */
    public function getElementSeriesByPageAndLimit(
        int $page,
        int $limit
    ): ElementSeriesCollection {
        $sql = "SELECT *
        FROM `elements`.`series`
        ORDER BY `updatedAt` DESC
        LIMIT :offset, :limit
        ";

        $offset = ($page - 1) * $limit;

        try {
            $statement = $this
                ->pdoReader
                ->getPdo()
                ->prepare($sql);

            if (empty($statement)) {
                throw new ElementSeriesEmptyException(
                    'ElementSeries. We could not retrieve the series list',
                    1
                );
            }

            $statement->execute([
                'limit'     => $limit,
                'offset'    => $offset
            ]);

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                throw new ElementSeriesEmptyException(
                    'ElementSeries. We could not retrieve series list',
                    3
                );
            }

            return $this
                ->elementSeriesFactory
                ->createCollectionFromRaw($result);
        } catch (\PDOException $e) {
            throw new ElementSeriesEmptyException(
                "ElementSeries. {$e->getMessage()}",
                2
            );
        }
    }

    /**
     * Get total
     *
     * @return int
     */
    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) AS total
        FROM `elements`.`series`";

        try {
            $statement = $this
                ->pdoReader
                ->getPdo()
                ->prepare($sql);

            $result = $statement->execute();

            if (empty($result)) {
                throw new TotalElementSeriesException(
                    __FUNCTION__ . ' We could not retrieve element series total',
                    1
                );
            }

            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                throw new TotalElementSeriesException(
                    __FUNCTION__ . ' We could not retrieve element series total',
                    3
                );
            }

            return (int) $result[0]['total'];
        } catch (\PDOException $e) {
            throw new TotalElementSeriesException(
                __FUNCTION__ . ' We could not retrieve element series total',
                2
            );
        }
    }
}
