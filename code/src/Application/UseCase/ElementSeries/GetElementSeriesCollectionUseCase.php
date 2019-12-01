<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementImageEmptyException;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeries;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetail;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailSaveException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailWriterInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesSaveException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesServiceInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesWriterInterface;

/**
 * Class GetElementSeriesCollectionUseCase
 *
 * @package BestThor\ScrappingMaster\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementSeriesCollectionUseCase
{

    /**
     * @var ElementSeriesServiceInterface
     */
    protected $elementSeriesService;

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * @var ElementSeriesWriterInterface
     */
    protected $elementSeriesWriter;

    /**
     * @var ElementSeriesDetailWriterInterface
     */
    protected $elementSeriesDetailWriter;

    /**
     * @var string
     */
    protected $filesDir;

    /**
     * @var string
     */
    protected $imgDir;

    /**
     * GetElementSeriesCollectionUseCase constructor.
     *
     * @param ElementSeriesServiceInterface $elementSeriesService
     * @param MTContentReaderRepositoryInterface $contentReaderRepository
     * @param ElementSeriesWriterInterface $elementSeriesWriter
     * @param string $filesDir
     * @param string $imgDir
     */
    public function __construct(
        ElementSeriesServiceInterface $elementSeriesService,
        MTContentReaderRepositoryInterface $contentReaderRepository,
        ElementSeriesWriterInterface $elementSeriesWriter,
        ElementSeriesDetailWriterInterface $elementSeriesDetailWriter,
        string $filesDir,
        string $imgDir
    ) {
        $this->elementSeriesService = $elementSeriesService;
        $this->elementSeriesWriter  = $elementSeriesWriter;
        $this->mtContentReaderRepository = $contentReaderRepository;
        $this->elementSeriesDetailWriter = $elementSeriesDetailWriter;
        $this->filesDir = $filesDir;
        $this->imgDir = $imgDir;
    }

    /**
     * @param GetElementSeriesCollectionUseCaseArguments $arguments
     *
     * @return GetElementSeriesCollectionUseCaseResponse
     */
    public function __invoke(
        GetElementSeriesCollectionUseCaseArguments $arguments
    ) : GetElementSeriesCollectionUseCaseResponse {
        $elementSeriesCollection = $this
            ->elementSeriesService
            ->getElementSeriesCollectionByPage(
                $arguments->getPage()
            );

        $errorImageArr  = [];
        $errorFileArr   = [];

        /** @var ElementSeries $elementSeries */
        foreach ($elementSeriesCollection as $elementSeries) {
            $elementDir = $this->filesDir . $elementSeries->getName();

            if (!is_dir($this->filesDir)) {
                mkdir($this->filesDir);
            }

            if (!is_dir($elementDir)) {
                mkdir($elementDir);
            }

            try {
                $staticImgDir = $this->imgDir . $elementSeries->getId() . '.jpg';

                if (!empty($elementSeries->getElementSeriesImage())) {
                    $imageContent = $this
                        ->mtContentReaderRepository
                        ->getElementImageFile(
                            $elementSeries
                                ->getElementSeriesImage()
                                ->getImageUrl()
                        );

                    $elementSeries
                        ->setElementSeriesImage(
                            $elementSeries
                                ->getElementSeriesImage()
                                ->setImageUrl(
                                    $staticImgDir
                                )
                        );

                    file_put_contents(
                        $staticImgDir,
                        $imageContent
                    );
                }
            } catch (ElementImageEmptyException $e) {
                $errorImageArr[] = $elementSeries->getId();
            }

            try {
                $this
                    ->elementSeriesWriter
                    ->persist($elementSeries);
            } catch (ElementSeriesSaveException $e) {
            }

            if (!empty($elementSeries->getElementSeriesDetailCollection())) {
                /** @var ElementSeriesDetail $elementSeriesDetail */
                foreach ($elementSeries->getElementSeriesDetailCollection() as $elementSeriesDetail) {
                    try {
                        $downloadContent = $this
                            ->mtContentReaderRepository
                            ->getElementDownloadFile(
                                $elementSeriesDetail
                                    ->getElementSeriesDownload()
                                    ->getDownloadLink()
                            );

                        $elementSeriesDetail
                            ->setSeriesId($elementSeries->getId());

                        $staticDir = $elementDir . DIRECTORY_SEPARATOR .
                            $elementSeriesDetail
                                ->getElementSeriesDownload()
                                ->getDownloadName();

                        $elementSeriesDetail
                            ->setElementSeriesDownload(
                                $elementSeriesDetail
                                    ->getElementSeriesDownload()
                                    ->setDownloadLink($staticDir)
                            );

                        file_put_contents(
                            $staticDir,
                            $downloadContent
                        );
                    } catch (ElementDownloadContentEmptyException $e) {
                        $errorFileArr[] = $elementSeriesDetail
                            ->getElementSeriesDownload()
                            ->getDownloadName();
                    }

                    try {
                        $this
                            ->elementSeriesDetailWriter
                            ->persist($elementSeriesDetail);
                    } catch (ElementSeriesDetailSaveException $e) {
                    }
                }
            }
        }

        return new GetElementSeriesCollectionUseCaseResponse(
            true,
            $elementSeriesCollection,
            $errorImageArr,
            $errorFileArr
        );
    }
}
