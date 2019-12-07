<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollectionEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;

/**
 * RetrieveElementGeneralCollectionUseCase
 * 
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralCollectionUseCase
{
    /**
     * ElementGeneralReader
     *
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $elementGeneralReader;

    /**
     * RetrieveElementGeneralCollectionUseCase constructor
     *
     * @param ElementGeneralReaderRepositoryInterface $elementGeneralReader
     */
    public function __construct(
        ElementGeneralReaderRepositoryInterface $elementGeneralReader
    ) {
        $this->elementGeneralReader = $elementGeneralReader;
    }

    /**
     * UseCase handle
     *
     * @param RetrieveElementGeneralCollectionUseCaseArguments $arguments
     * @return RetrieveElementGeneralCollectionUseCaseResponse
     */
    public function handle(
        RetrieveElementGeneralCollectionUseCaseArguments $arguments
    ) : RetrieveElementGeneralCollectionUseCaseResponse {
        $previousPage = null;
        $nextPage = null;

        try {
            $elementGeneralCollection = $this
                ->elementGeneralReader
                ->getElementGeneralByPage(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            $total = $this
                ->elementGeneralReader
                ->getTotal();

            $totalPages = ceil($total/$arguments->getLimit());

            if ($arguments->getPage() > 1) {
                $previousPage = $arguments->getPage() - 1;
            }

            if ($arguments->getPage() < $totalPages) {
                $nextPage = $arguments->getPage() + 1;
            }

            return new RetrieveElementGeneralCollectionUseCaseResponse(
                true,
                null,
                $total,
                $previousPage,
                $nextPage,
                $elementGeneralCollection
            );
        } catch (ElementGeneralCollectionEmptyException $e) {
            return new RetrieveElementGeneralCollectionUseCaseResponse(
                false,
                $e->getMessage(),
                $total,
                $previousPage,
                $nextPage,
                null
            );
        }
    }
}
