<?php

namespace BestThor\ScrappingMaster\Infrastructure\Factory\General;

use BestThor\ScrappingMaster\Domain\General\ElementDetail;
use BestThor\ScrappingMaster\Domain\General\ElementDetailFactoryInterface;

/**
 * Class ElementDetailFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementDetailFactory implements ElementDetailFactoryInterface
{

    /**
     * @param array $rawElementDetail
     *
     * @return ElementDetail
     */
    public function createElementDetailFromRaw(
        array $rawElementDetail
    ): ElementDetail {

        $elementGenre           = null;
        $elementFormat          = null;
        $elementDescription     = null;
        $elementCoverImg        = null;
        $elementCoverImgName    = null;
        $current                = new \DateTimeImmutable();

        if (!empty($rawElementDetail['publishedDate'])) {
            $current = \DateTimeImmutable::createFromFormat(
                'Y-m-d',
                $rawElementDetail['publishedDate']
            );

            if (empty($current)) {
                $current = new \DateTimeImmutable();
            }
        }

        if (!empty($rawElementDetail['genre'])) {
            $elementGenre = $rawElementDetail['genre'];
        }

        if (!empty($rawElementDetail['format'])) {
            $elementFormat = $rawElementDetail['format'];
        }

        if (!empty($rawElementDetail['description'])) {
            $elementDescription = $rawElementDetail['description'];
        }

        if (!empty($rawElementDetail['coverImg'])) {
            $elementCoverImg = $rawElementDetail['coverImg'];
        }

        if (!empty($rawElementDetail['coverImgName'])) {
            $elementCoverImgName = $rawElementDetail['coverImgName'];
        }

        return new ElementDetail(
            $current,
            $elementGenre,
            $elementFormat,
            $elementDescription,
            $elementCoverImg,
            $elementCoverImgName
        );
    }
}
