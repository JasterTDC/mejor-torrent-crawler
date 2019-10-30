<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;

/**
 * Class MysqlPdoElementGeneralReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralReaderRepository
    implements ElementGeneralReaderRepositoryInterface
{
    /**
     * @var PdoAccess
     */
    protected $pdoAccess;

    /**
     * MysqlPdoElementGeneralReaderRepository constructor.
     *
     * @param PdoAccess $pdoAccess
     */
    public function __construct(
        PdoAccess $pdoAccess
    ) {
        $this->pdoAccess = $pdoAccess;
    }

    /**
     * @param int $page
     *
     * @return ElementGeneralCollection
     */
    public function getElementGeneralByPage(
        int $page
    ) : ElementGeneralCollection {
    }
}
