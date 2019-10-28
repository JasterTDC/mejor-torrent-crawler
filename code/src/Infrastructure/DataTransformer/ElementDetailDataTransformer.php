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
            $ret['elementPublishedDate'] = $elementDetail
                ->getElementPublishedDate()
                ->format('Y-m-d');
        }

        if (!empty($elementDetail->getElementFormat())) {
            $ret['elementFormat'] = utf8_encode($elementDetail->getElementFormat());
        }

        if (!empty($elementDetail->getElementDescription())) {
            $ret['elementDescription'] = utf8_encode($elementDetail->getElementDescription());
        }

        if (!empty($elementDetail->getElementGenre())) {
            $ret['elementGenre'] = utf8_encode($elementDetail->getElementGenre());
        }

        if (!empty($elementDetail->getElementCoverImg())) {
            $ret['elementCoverImg'] = $elementDetail->getElementCoverImg();
        }

        if (!empty($elementDetail->getElementCoverImgName())) {
            $ret['elementCoverImgName'] = $elementDetail->getElementCoverImgName();
        }

        if (!empty($elementDetail->getElementDir())) {
            $ret['elementDir'] = $elementDetail->getElementDir();
        }

        if (!empty($elementDetail->getElementYearDir())) {
            $ret['elementYearDir'] = $elementDetail->getElementYearDir();
        }

        if (!empty($elementDetail->getElementMonthDir())) {
            $ret['elementMonthDir'] = $elementDetail->getElementMonthDir();
        }

        if (!empty($elementDetail->getElementDownloadLink())) {
            $ret['elementDownloadLink'] = $elementDetail->getElementDownloadLink();
        }

        return $ret;
    }
}
