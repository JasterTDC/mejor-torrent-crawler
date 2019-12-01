<?php


namespace BestThor\ScrappingMaster\Infrastructure\Factory\Series;

use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesFactoryInterface;

/**
 * Class FromMysqlElementSeriesFactory
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class FromMysqlElementSeriesFactory implements ElementSeriesFactoryInterface
{

    /**
     * Date format
     */
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var FromMysqlElementSeriesImageFactory
     */
    protected $elementSeriesImageFactory;

    /**
     * @var FromMysqlElementSeriesDescriptionFactory
     */
    protected $elementSeriesDescriptionFactory;

    /**
     * FromMysqlElementSeriesFactory constructor.
     *
     * @param FromMysqlElementSeriesImageFactory $elementSeriesImageFactory
     * @param FromMysqlElementSeriesDescriptionFactory $elementSeriesDescriptionFactory
     */
    public function __construct(
        FromMysqlElementSeriesImageFactory $elementSeriesImageFactory,
        FromMysqlElementSeriesDescriptionFactory $elementSeriesDescriptionFactory
    ) {
        $this->elementSeriesImageFactory = $elementSeriesImageFactory;
        $this->elementSeriesDescriptionFactory = $elementSeriesDescriptionFactory;
    }

    /**
     * @param array $rawElementSeries
     *
     * @return ElementSeries
     */
    public function createFromRaw(
        array $rawElementSeries
    ) : ElementSeries {
        try {
            $createdAt = \DateTimeImmutable::createFromFormat(
                self::DATETIME_FORMAT,
                $rawElementSeries['createdAt']
            );

            $updatedAt = \DateTimeImmutable::createFromFormat(
                self::DATETIME_FORMAT,
                $rawElementSeries['updatedAt']
            );
        } catch (\Exception $e) {
            $createdAt = new \DateTimeImmutable();
            $updatedAt = new \DateTimeImmutable();
        }

        if (empty($createdAt)) {
            $createdAt = new \DateTimeImmutable();
        }

        if (empty($updatedAt)) {
            $updatedAt = new \DateTimeImmutable();
        }

        return new ElementSeries(
            (int) $rawElementSeries['id'],
            (int) $rawElementSeries['firstEpisodeId'],
            $rawElementSeries['name'],
            $rawElementSeries['slug'],
            $rawElementSeries['link'],
            $createdAt,
            $updatedAt,
            $this
                ->elementSeriesImageFactory
                ->createFromRaw($rawElementSeries),
            $this
                ->elementSeriesDescriptionFactory
                ->createFromRaw($rawElementSeries),
            null
        );
    }

    /**
     * @param array $rawCollection
     *
     * @return ElementSeriesCollection
     */
    public function createCollectionFromRaw(
        array $rawCollection
    ) : ElementSeriesCollection {
        $elementSeriesCollection = new ElementSeriesCollection();

        foreach ($rawCollection as $rawElementSeries) {
            $elementSeriesCollection->add(
                $this->createFromRaw($rawElementSeries)
            );
        }

        return $elementSeriesCollection;
    }
}
