<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository\General;

use BestThor\ScrappingMaster\Domain\General\ElementGeneral;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralPersistException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralWriterRepositoryInterface;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;

/**
 * Class MysqlPdoElementGeneralWriterRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralWriterRepository implements ElementGeneralWriterRepositoryInterface
{
    /**
     * Date format
     */
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var PdoAccess
     */
    protected $pdoWriter;

    /**
     * MysqlPdoElementGeneralWriterRepository constructor.
     *
     * @param PdoAccess $pdoWriter
     */
    public function __construct(
        PdoAccess $pdoWriter
    ) {
        $this->pdoWriter = $pdoWriter;
    }

    /**
     * @param ElementGeneral $elementGeneral
     *
     * @return bool
     * @throws ElementGeneralPersistException
     */
    public function persist(ElementGeneral $elementGeneral): bool
    {
        $sql = "INSERT INTO `elements`.`general` (
            `id`, 
            `link`, 
            `slug`, 
            `name`, 
            `publishedDate`, 
            `genre`,
            `format`,
            `description`,
            `coverImg`,
            `coverImgName`,
            `downloadTorrentUrl`,
            `downloadName`,
            `createdAt`,
            `updatedAt`
        ) VALUES (
            :id, 
            :link, 
            :slug, 
            :elementName, 
            :publishedDate, 
            :genre,
            :format,
            :description,
            :coverImg,
            :coverImgName,
            :downloadTorrentUrl,
            :downloadName,
            :createdAt,
            :updatedAt
        ) ON DUPLICATE KEY UPDATE `updatedAt` = VALUES(`updatedAt`)
        ";

        $publishedDate      = null;
        $genre              = null;
        $format             = null;
        $description        = null;
        $coverImg           = null;
        $coverImgName       = null;
        $downloadTorrentUrl = null;
        $downloadName       = null;

        if (
            !empty($elementGeneral->getElementDetail()) &&
            !empty($elementGeneral->getElementDetail()->getElementPublishedDate())
        ) {
            $publishedDate = $elementGeneral
                ->getElementDetail()
                ->getElementPublishedDate()
                ->format(self::DATETIME_FORMAT);

            $genre = $elementGeneral
                ->getElementDetail()
                ->getElementGenre();

            $format = $elementGeneral
                ->getElementDetail()
                ->getElementFormat();

            $description = $elementGeneral
                ->getElementDetail()
                ->getElementDescription();

            $coverImg = $elementGeneral
                ->getElementDetail()
                ->getElementCoverImg();

            $coverImgName = $elementGeneral
                ->getElementDetail()
                ->getElementCoverImgName();
        }

        if (!empty($elementGeneral->getElementDownload())) {
            $downloadTorrentUrl = $elementGeneral
                ->getElementDownload()
                ->getElementDownloadTorrentUrl();

            $downloadName = $elementGeneral
                ->getElementDownload()
                ->getElementDownloadName();
        }

        $parameters = [
            'id'                    => $elementGeneral->getElementId(),
            'link'                  => $elementGeneral->getElementLink(),
            'slug'                  => $elementGeneral->getElementSlug(),
            'elementName'           => $elementGeneral->getElementName(),
            'publishedDate'         => $publishedDate,
            'genre'                 => $genre,
            'format'                => $format,
            'description'           => $description,
            'coverImg'              => $coverImg,
            'coverImgName'          => $coverImgName,
            'downloadTorrentUrl'    => $downloadTorrentUrl,
            'downloadName'          => $downloadName,
            'createdAt'             => $elementGeneral->getCreatedAt()->format(self::DATETIME_FORMAT),
            'updatedAt'             => $elementGeneral->getUpdatedAt()->format(self::DATETIME_FORMAT)
        ];

        try {
            $statement = $this
                ->pdoWriter
                ->getPdo()
                ->prepare($sql);

            return $statement->execute($parameters);
        } catch (\PDOException $e) {
            throw new ElementGeneralPersistException(
                '[ElementGeneralWriter][persist] ' . $e->getMessage(),
                1
            );
        }
    }
}
