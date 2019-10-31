<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;

/**
 * Class GetElementGeneralUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralUseCase
{
    /**
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $elementGeneralReaderRepository;

    /**
     * GetElementGeneralUseCase constructor.
     *
     * @param ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
     */
    public function __construct(
        ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
    ) {
        $this->elementGeneralReaderRepository = $elementGeneralReaderRepository;
    }

    /**
     * @param GetElementGeneralUseCaseArguments $arguments
     *
     * @return GetElementGeneralUseCaseResponse
     */
    public function handle(
        GetElementGeneralUseCaseArguments $arguments
    ) : GetElementGeneralUseCaseResponse {
        if ($arguments->getPage() <= 0) {
            return new GetElementGeneralUseCaseResponse(
                false,
                'Page number has to be more or equals than 1',
                null
            );
        }

        if ($arguments->getLimit() <= 0) {
            return new GetElementGeneralUseCaseResponse(
                false,
                'Limit has to be more than 1',
                null
            );
        }

        try {
            $elementGeneralCollection = $this
                ->elementGeneralReaderRepository
                ->getElementGeneralByPage(
                    $arguments->getPage(),
                    $arguments->getLimit()
                );

            return new GetElementGeneralUseCaseResponse(
                true,
                null,
                $elementGeneralCollection
            );
        } catch (\Exception $e) {
            return new GetElementGeneralUseCaseResponse(
                false,
                $e->getMessage(),
                null
            );
        }
    }
}
