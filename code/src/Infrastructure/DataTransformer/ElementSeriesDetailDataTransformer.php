<?php

namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;

/**
 * Class ElementSeriesDetailDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDetailDataTransformer
{
    /**
     * @var ElementSeriesDownloadDataTransformer
     */
    protected $elementSeriesDownloadDataTransformer;

    /**
     * ElementSeriesDetailDataTransformer constructor.
     *
     * @param ElementSeriesDownloadDataTransformer $elementSeriesDownloadDataTransformer
     */
    public function __construct(
        ElementSeriesDownloadDataTransformer $elementSeriesDownloadDataTransformer
    ) {
        $this->elementSeriesDownloadDataTransformer = $elementSeriesDownloadDataTransformer;
    }

    /**
     * @param ElementSeriesDetail $elementSeriesDetail
     *
     * @return array
     */
    public function transform(
        ElementSeriesDetail $elementSeriesDetail
    ): array {
        $ret = [];

        $ret['id']      = $elementSeriesDetail->getId();
        $ret['name']    = $elementSeriesDetail->getName();
        $ret['link']    = $elementSeriesDetail->getLink();

        if (!empty($elementSeriesDetail->getElementSeriesDownload())) {
            $ret['download'] = $this
                ->elementSeriesDownloadDataTransformer
                ->transform($elementSeriesDetail->getElementSeriesDownload());
        }

        return $ret;
    }

    /**
     * @param ElementSeriesDetailCollection $elementSeriesDetailCollection
     *
     * @return array
     */
    public function transformCollection(
        ElementSeriesDetailCollection $elementSeriesDetailCollection
    ): array {
        $ret = [];

        /** @var ElementSeriesDetail $elementSeriesDetail */
        foreach ($elementSeriesDetailCollection as $elementSeriesDetail) {
            $ret[] = $this->transform($elementSeriesDetail);
        }

        return $ret;
    }
}
