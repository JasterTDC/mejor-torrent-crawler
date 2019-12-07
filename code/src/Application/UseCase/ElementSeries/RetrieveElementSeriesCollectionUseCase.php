<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementSeries;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCaseResponse;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesReaderInterface;

/**
 * RetrieveElementSeriesColectionUseCase class
 * 
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementSeriesCollectionUseCase
{

    /** @var ElementSeriesReaderInterface $elementSeriesReaderRepository */
    protected $elementSeriesReaderRepository;

    /**
     * RetrieveElementSeriesColectionUseCase constructor
     *
     * @param ElementSeriesReaderInterface $elementSeriesReaderRepository
     */
    public function __construct(
        ElementSeriesReaderInterface $elementSeriesReaderRepository
    ) {
        $this->elementSeriesReaderRepository = $elementSeriesReaderRepository;
    }

    /**
     * Use case handle
     *
     * @param RetrieveElementSeriesCollectionUseCaseArguments $arguments
     *
     * @return RetrieveElementGeneralCollectionUseCaseResponse
     */
    public function handle(
        RetrieveElementSeriesCollectionUseCaseArguments $arguments
    ) : RetrieveElementSeriesCollectionUseCaseResponse {

        $previousPage = null;
        $nextPage = null;

        try {
            $elementSeriesCollection = $this
                ->elementSeriesReaderRepository
                ->getElementSeriesByPageAndLimit(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            $total = $this
                ->elementSeriesReaderRepository
                ->getTotal();

            $totalPages = ceil($total/$arguments->getLimit());

            if ($arguments->getPage() > 1) {
                $previousPage = $arguments->getPage() - 1;
            }

            if ($arguments->getPage() < $totalPages) {
                $nextPage = $arguments->getPage() + 1;
            }

            return new RetrieveElementSeriesCollectionUseCaseResponse(
                true,
                $elementSeriesCollection,
                $previousPage,
                $nextPage,
                null
            );
        } catch (\Exception $e) {
            return new RetrieveElementSeriesCollectionUseCaseResponse(
                false,
                null,
                null,
                null,
                $e->getMessage()
            );
        }
    }
}
