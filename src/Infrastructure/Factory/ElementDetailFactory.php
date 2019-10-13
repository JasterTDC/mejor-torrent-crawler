<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory;

use BestThor\ScrappingMaster\Domain\ElementDetail;
use BestThor\ScrappingMaster\Domain\ElementDetailFactoryInterface;

/**
 * Class ElementDetailFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailFactory implements ElementDetailFactoryInterface
{

    /**
     * @var string
     */
    protected $baseDir;

    /**
     * ElementDetailFactory constructor.
     * @param string $baseDir
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * @param array $rawElementDetail
     *
     * @return ElementDetail
     */
    public function createElementDetailFromRaw(
        array $rawElementDetail
    ) : ElementDetail {
        $current = \DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $rawElementDetail['elementPublishedDate']
        );
        $elementGenre           = null;
        $elementFormat          = null;
        $elementDescription     = null;
        $elementCoverImg        = null;
        $elementCoverImgName    = null;
        $elementDownloadLink    = null;
        $elementDir             = null;
        $elementYearDir         = null;
        $elementMonthDir        = null;

        if (!empty($rawElementDetail['elementGenre'])) {
            $elementGenre = $rawElementDetail['elementGenre'];
        }

        if (!empty($rawElementDetail['elementFormat'])) {
            $elementFormat = $rawElementDetail['elementFormat'];
        }

        if (!empty($rawElementDetail['elementDescription'])) {
            $elementDescription = $rawElementDetail['elementDescription'];
        }

        if (!empty($rawElementDetail['elementCoverImg'])) {
            $elementCoverImg = $rawElementDetail['elementCoverImg'];
        }

        if (!empty($rawElementDetail['elementCoverImgName'])) {
            $elementCoverImgName = $rawElementDetail['elementCoverImgName'];
        }

        if (!empty($rawElementDetail['elementDownloadLink'])) {
            $elementDownloadLink = $rawElementDetail['elementDownloadLink'];
        }

        if (!empty($rawElementDetail['elementDir'])) {
            $elementDir = $rawElementDetail['elementDir'];
        }

        if (!empty($current)) {
            $elementDir = $this->baseDir . DIRECTORY_SEPARATOR .
                $current->format('Y') . DIRECTORY_SEPARATOR .
                $current->format('m') . DIRECTORY_SEPARATOR;

            $elementYearDir = $this->baseDir . DIRECTORY_SEPARATOR .
                $current->format('Y') . DIRECTORY_SEPARATOR;

            $elementMonthDir = $this->baseDir . DIRECTORY_SEPARATOR .
                $current->format('Y') . DIRECTORY_SEPARATOR .
                $current->format('m') . DIRECTORY_SEPARATOR;
        }

        return new ElementDetail(
            !empty($current) ? $current : null,
            $elementGenre,
            $elementFormat,
            $elementDescription,
            $elementCoverImg,
            $elementCoverImgName,
            $elementDownloadLink,
            $elementDir,
            $elementYearDir,
            $elementMonthDir
        );
    }
}
