<?php


namespace BestThor\ScrappingMaster\Infrastructure\Service;

use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesServiceInterface;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDetailParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesDownloadParser;
use BestThor\ScrappingMaster\Infrastructure\Parser\ElementSeriesParser;

/**
 * Class SeriesService
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Service
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SeriesService implements ElementSeriesServiceInterface
{
    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReadRepository;

    /**
     * @var ElementSeriesParser
     */
    protected $elementSeriesParser;

    /**
     * @var ElementSeriesDetailParser
     */
    protected $elementSeriesDetailParser;

    /**
     * @var ElementSeriesDownloadParser
     */
    protected $elementSeriesDownloadParser;

    /**
     * SeriesService constructor.
     *
     * @param MTContentReaderRepositoryInterface $mtContentReadRepository
     * @param ElementSeriesParser $elementSeriesParser
     * @param ElementSeriesDetailParser $elementSeriesDetailParser
     * @param ElementSeriesDownloadParser $elementSeriesDownloadParser
     */
    public function __construct(
        MTContentReaderRepositoryInterface $mtContentReadRepository,
        ElementSeriesParser $elementSeriesParser,
        ElementSeriesDetailParser $elementSeriesDetailParser,
        ElementSeriesDownloadParser $elementSeriesDownloadParser
    ) {
        $this->mtContentReadRepository      = $mtContentReadRepository;
        $this->elementSeriesParser          = $elementSeriesParser;
        $this->elementSeriesDetailParser    = $elementSeriesDetailParser;
        $this->elementSeriesDownloadParser  = $elementSeriesDownloadParser;
    }

    /**
     * @param int $page
     *
     * @return ElementSeriesCollection
     */
    public function getElementSeriesCollectionByPage(
        int $page
    ) : ElementSeriesCollection {
        try {
            $seriesContent = $this
                ->mtContentReadRepository
                ->getElementSeriesContent($page);

            $this
                ->elementSeriesParser
                ->setContent($seriesContent);

            $elementSeriesCollection = $this
                ->elementSeriesParser
                ->getElementSeriesCollection();

            if (empty($elementSeriesCollection)) {
                return new ElementSeriesCollection();
            }

            /** @var ElementSeries $elementSeries */
            foreach ($elementSeriesCollection as $elementSeries) {
                $seriesDetailContent = $this
                    ->mtContentReadRepository
                    ->getElementSeriesDetailContent(
                        $elementSeries->getLink()
                    );

                $this
                    ->elementSeriesDetailParser
                    ->setContent($seriesDetailContent);

                $elementDetailCollection = $this
                    ->elementSeriesDetailParser
                    ->getElementDetailCollection();
                $elementSeriesDescription = $this
                    ->elementSeriesDetailParser
                    ->getElementSeriesDescription();
                $elementSeriesImage = $this
                    ->elementSeriesDetailParser
                    ->getElementSeriesImage();

                $finalElementSeriesDetailCollection = new ElementSeriesDetailCollection();

                if (!empty($elementDetailCollection)) {
                    /** @var ElementSeriesDetail $elementSeriesDetail */
                    foreach ($elementDetailCollection as $elementSeriesDetail) {
                        $elementSeriesDownloadContent = $this
                            ->mtContentReadRepository
                            ->getElementSeriesDownloadContent(
                                $elementSeriesDetail->getId()
                            );

                        $this
                            ->elementSeriesDownloadParser
                            ->setContent($elementSeriesDownloadContent);

                        $elementSeriesDetail
                            ->setElementSeriesDownload(
                                $this
                                    ->elementSeriesDownloadParser
                                    ->getElementSeriesDownload()
                            );

                        $finalElementSeriesDetailCollection->add(
                            $elementSeriesDetail
                        );
                    }
                }

                $elementSeries
                    ->setElementSeriesDescription($elementSeriesDescription);
                $elementSeries
                    ->setElementSeriesImage($elementSeriesImage);
                $elementSeries
                    ->setElementSeriesDetailCollection($finalElementSeriesDetailCollection);
            }

            return $elementSeriesCollection;
        } catch (ElementSeriesEmptyException $e) {
        } catch (ElementSeriesDetailEmptyException $e) {
        }
    }
}
