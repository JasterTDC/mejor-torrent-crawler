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
        try {
            $elementGeneralCollection = $this
                ->elementGeneralReader
                ->getElementGeneralByPage(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            return new RetrieveElementGeneralCollectionUseCaseResponse(
                true,
                null,
                $elementGeneralCollection
            );
        } catch (ElementGeneralCollectionEmptyException $e) {
            return new RetrieveElementGeneralCollectionUseCaseResponse(
                false,
                $e->getMessage(),
                null
            );
        }
    }
}
