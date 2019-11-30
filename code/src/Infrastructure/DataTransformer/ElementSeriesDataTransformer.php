<?php


namespace BestThor\ScrappingMaster\Infrastructure\DataTransformer;

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;

/**
 * Class ElementSeriesDataTransformer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\DataTransformer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDataTransformer
{
    /**
     * @var ElementSeriesImageDataTransformer
     */
    protected $elementSeriesImageDataTransformer;

    /**
     * @var ElementSeriesDescriptionDataTransformer
     */
    protected $elementSeriesDescriptionDataTransformer;

    /**
     * @var ElementSeriesDetailDataTransformer
     */
    protected $elementSeriesDetailDataTransformer;

    /**
     * ElementSeriesDataTransformer constructor.
     *
     * @param ElementSeriesImageDataTransformer $elementSeriesImageDataTransformer
     * @param ElementSeriesDescriptionDataTransformer $elementSeriesDescriptionDataTransformer
     * @param ElementSeriesDetailDataTransformer $elementSeriesDetailDataTransformer
     */
    public function __construct(
        ElementSeriesImageDataTransformer $elementSeriesImageDataTransformer,
        ElementSeriesDescriptionDataTransformer $elementSeriesDescriptionDataTransformer,
        ElementSeriesDetailDataTransformer $elementSeriesDetailDataTransformer
    ) {
        $this->elementSeriesImageDataTransformer = $elementSeriesImageDataTransformer;
        $this->elementSeriesDescriptionDataTransformer = $elementSeriesDescriptionDataTransformer;
        $this->elementSeriesDetailDataTransformer = $elementSeriesDetailDataTransformer;
    }

    /**
     * @param ElementSeries $elementSeries
     *
     * @return array
     */
    public function transform(
        ElementSeries $elementSeries
    ) : array {
        $ret = [];

        $ret['id']          = $elementSeries->getId();
        $ret['firstEpId']   = $elementSeries->getFirstEpId();
        $ret['name']        = $elementSeries->getName();
        $ret['slug']        = $elementSeries->getSlug();
        $ret['link']        = $elementSeries->getLink();

        if (!empty($elementSeries->getElementSeriesDetailCollection())) {
            $ret['detailCollection'] = $this
                ->elementSeriesDetailDataTransformer
                ->transformCollection(
                    $elementSeries->getElementSeriesDetailCollection()
                );
        }

        if (!empty($elementSeries->getElementSeriesDescription())) {
            $ret['description'] = $this
                ->elementSeriesDescriptionDataTransformer
                ->transform($elementSeries->getElementSeriesDescription());
        }

        if (!empty($elementSeries->getElementSeriesImage())) {
            $ret['image'] = $this
                ->elementSeriesImageDataTransformer
                ->transform($elementSeries->getElementSeriesImage());
        }

        return $ret;
    }

    /**
     * @param ElementSeriesCollection $elementSeriesCollection
     *
     * @return array
     */
    public function transformCollection(
        ElementSeriesCollection $elementSeriesCollection
    ) : array {
        $ret = [];

        /** @var ElementSeries $elementSeries */
        foreach ($elementSeriesCollection as $elementSeries) {
            $ret[] = $this->transform($elementSeries);
        }

        return $ret;
    }
}
