<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\ElementDetail;

/**
 * Class ElementDetailDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailDataTransformer
{

    /**
     * @param ElementDetail|null $elementDetail
     *
     * @return array
     */
    public function transform(
        ?ElementDetail $elementDetail
    ) : array {
        $ret = [];

        if (empty($elementDetail)) {
            return $ret;
        }

        if (!empty($elementDetail->getElementPublishedDate())) {
            $ret['publishedDate'] = $elementDetail
                ->getElementPublishedDate()
                ->format('Y-m-d');
        }

        if (!empty($elementDetail->getElementFormat())) {
            $ret['format'] = $elementDetail->getElementFormat();
        }

        if (!empty($elementDetail->getElementDescription())) {
            $ret['description'] = $elementDetail->getElementDescription();
        }

        if (!empty($elementDetail->getElementGenre())) {
            $ret['genre'] = $elementDetail->getElementGenre();
        }

        if (!empty($elementDetail->getElementCoverImg())) {
            $ret['coverImg'] = $elementDetail->getElementCoverImg();
        }

        if (!empty($elementDetail->getElementCoverImgName())) {
            $ret['coverImgName'] = $elementDetail->getElementCoverImgName();
        }

        if (!empty($elementDetail->getElementDir())) {
            $ret['dir'] = $elementDetail->getElementDir();
        }

        if (!empty($elementDetail->getElementYearDir())) {
            $ret['yearDir'] = $elementDetail->getElementYearDir();
        }

        if (!empty($elementDetail->getElementMonthDir())) {
            $ret['monthDir'] = $elementDetail->getElementMonthDir();
        }

        if (!empty($elementDetail->getElementDownloadLink())) {
            $ret['downloadLink'] = $elementDetail->getElementDownloadLink();
        }

        return $ret;
    }
}
