<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesSaveException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesWriterInterface;

/**
 * Class MysqlPdoElementSeriesWriterRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesWriterRepository implements ElementSeriesWriterInterface
{

    /**
     * Date format
     */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var PdoAccess
     */
    protected $pdoWriter;

    /**
     * MysqlPdoElementSeriesWriterRepository constructor.
     *
     * @param PdoAccess $pdoWriter
     */
    public function __construct(PdoAccess $pdoWriter)
    {
        $this->pdoWriter = $pdoWriter;
    }

    /**
     * @param ElementSeries $elementSeries
     *
     * @return bool
     * @throws ElementSeriesSaveException
     */
    public function persist(
        ElementSeries $elementSeries
    ): bool {
        $sql = "INSERT INTO `elements`.`series` (
            `id`,
            `firstEpisodeId`,
            `name`,
            `slug`,
            `link`,
            `imageUrl`,
            `imageName`,
            `description`,
            `createdAt`,
            `updatedAt`
        ) VALUES (
            :id,
            :firstEpisodeId,
            :name,
            :slug,
            :link,
            :imageUrl,
            :imageName,
            :description,
            :createdAt,
            :updatedAt
        ) ON DUPLICATE KEY UPDATE `updatedAt` = VALUES(`updatedAt`)";

        try {
            $statement = $this
                ->pdoWriter
                ->getPdo()
                ->prepare($sql);

            $imageUrl       = null;
            $imageName      = null;
            $description    = null;

            if (!empty($elementSeries->getElementSeriesImage())) {
                $imageUrl = $elementSeries
                    ->getElementSeriesImage()
                    ->getImageUrl();
            }

            if (!empty($elementSeries->getElementSeriesImage())) {
                $imageName = $elementSeries
                    ->getElementSeriesImage()
                    ->getImageName();
            }

            if (!empty($elementSeries->getElementSeriesDescription())) {
                $description = $elementSeries
                    ->getElementSeriesDescription()
                    ->getDescription();
            }

            return $statement->execute([
                'id'                => $elementSeries->getId(),
                'firstEpisodeId'    => $elementSeries->getFirstEpId(),
                'name'              => $elementSeries->getName(),
                'slug'              => $elementSeries->getSlug(),
                'link'              => $elementSeries->getLink(),
                'imageUrl'          => $imageUrl,
                'imageName'         => $imageName,
                'description'       => $description,
                'createdAt'         => $elementSeries->getCreatedAt()->format(self::DATE_FORMAT),
                'updatedAt'         => $elementSeries->getUpdatedAt()->format(self::DATE_FORMAT)
            ]);
        } catch (\PDOException $e) {
            throw new ElementSeriesSaveException(
                "ElementSeriesSave. {$e->getMessage()}",
                2
            );
        }
    }
}
