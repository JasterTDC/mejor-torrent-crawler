<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailSaveException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailWriterInterface;

/**
 * Class MysqlPdoElementSeriesEpisodeWriterRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesDetailWriterRepository implements ElementSeriesDetailWriterInterface
{

    /**
     * Date format
     */
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var PdoAccess
     */
    protected $pdoWriter;

    /**
     * MysqlPdoElementSeriesEpisodeWriterRepository constructor.
     *
     * @param PdoAccess $pdoWriter
     */
    public function __construct(
        PdoAccess $pdoWriter
    ) {
        $this->pdoWriter = $pdoWriter;
    }

    /**
     * @param ElementSeriesDetail $elementSeriesDetail
     *
     * @return bool
     * @throws ElementSeriesDetailSaveException
     */
    public function persist(
        ElementSeriesDetail $elementSeriesDetail
    ) : bool {
        $sql = "INSERT INTO `elements`.`series_episodes` (
            `id`,
            `seriesId`,
            `name`,
            `link`,
            `downloadName`,
            `downloadLink`,
            `createdAt`,
            `updatedAt`
        ) VALUES (
            :id,
            :seriesId,
            :name,
            :link,
            :downloadName,
            :downloadLink,
            :createdAt,
            :updatedAt
        )";

        try {
            $statement = $this
                ->pdoWriter
                ->getPdo()
                ->prepare($sql);

            if (empty($statement)) {
                throw new ElementSeriesDetailSaveException(
                    'ElementSeriesDetail. The selected detail cannot be saved',
                    1
                );
            }

            $downloadName   = null;
            $downloadLink   = null;

            if (!empty($elementSeriesDetail->getElementSeriesDownload())) {
                $downloadName = $elementSeriesDetail
                    ->getElementSeriesDownload()
                    ->getDownloadName();

                $downloadLink = $elementSeriesDetail
                    ->getElementSeriesDownload()
                    ->getDownloadLink();
            }

            return $statement
                ->execute([
                    'id'            => $elementSeriesDetail->getId(),
                    'seriesId'      => $elementSeriesDetail->getSeriesId(),
                    'name'          => $elementSeriesDetail->getName(),
                    'link'          => $elementSeriesDetail->getLink(),
                    'downloadName'  => $downloadName,
                    'downloadLink'  => $downloadLink,
                    'createdAt'     => $elementSeriesDetail->getCreatedAt()->format(self::DATE_FORMAT),
                    'updatedAt'     => $elementSeriesDetail->getUpdatedAt()->format(self::DATE_FORMAT)
                ]);
        } catch (\PDOException $e) {
            throw new ElementSeriesDetailSaveException(
                "ElementSeriesDetail. {$e->getMessage()}",
                2
            );
        }
    }
}
