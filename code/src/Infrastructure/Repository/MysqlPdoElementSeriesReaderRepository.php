<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesFactoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesReaderInterface;

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
    ) : ElementSeriesCollection {
        $sql = "SELECT *
        FROM `elements`.`series`
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

            return $this
                ->elementSeriesFactory
                ->createCollectionFromRaw($statement->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\PDOException $e) {
            throw new ElementSeriesEmptyException(
                "ElementSeries. {$e->getMessage()}",
                2
            );
        }
    }

}
