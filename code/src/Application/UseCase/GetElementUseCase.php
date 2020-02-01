<?php

namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesReaderInterface;

/**
 * Class GetElementUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementUseCase
{

    /**
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $elementGeneralReader;

    /**
     * @var ElementSeriesReaderInterface
     */
    protected $elementSeriesReader;

    /**
     * GetElementUseCase constructor.
     *
     * @param ElementGeneralReaderRepositoryInterface $elementGeneralReader
     * @param ElementSeriesReaderInterface $elementSeriesReader
     */
    public function __construct(
        ElementGeneralReaderRepositoryInterface $elementGeneralReader,
        ElementSeriesReaderInterface $elementSeriesReader
    ) {
        $this->elementGeneralReader = $elementGeneralReader;
        $this->elementSeriesReader = $elementSeriesReader;
    }

    /**
     * @param GetElementUseCaseArguments $arguments
     *
     * @return GetElementUseCaseResponse
     */
    public function handle(
        GetElementUseCaseArguments $arguments
    ): GetElementUseCaseResponse {
        try {
            $elementGeneralCollection = $this
                ->elementGeneralReader
                ->getElementGeneralByPage(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            $elementSeriesCollection = $this
                ->elementSeriesReader
                ->getElementSeriesByPageAndLimit(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            return new GetElementUseCaseResponse(
                true,
                null,
                $elementGeneralCollection,
                $elementSeriesCollection
            );
        } catch (\Exception $e) {
            return new GetElementUseCaseResponse(
                false,
                $e->getMessage(),
                null,
                null
            );
        }
    }
}
