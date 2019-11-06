<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementGeneralPersistException;
use BestThor\ScrappingMaster\Domain\ElementGeneralWriterRepositoryInterface;

/**
 * Class SaveElementGeneralUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class SaveElementGeneralUseCase
{

    /**
     * @var ElementGeneralWriterRepositoryInterface
     */
    protected $elementGeneralWriterRepository;

    /**
     * SaveElementGeneralUseCase constructor.
     *
     * @param ElementGeneralWriterRepositoryInterface $elementGeneralWriterRepository
     */
    public function __construct(
        ElementGeneralWriterRepositoryInterface $elementGeneralWriterRepository
    ) {
        $this->elementGeneralWriterRepository = $elementGeneralWriterRepository;
    }

    /**
     * @param SaveElementGeneralUseCaseArguments $arguments
     *
     * @return SaveElementGeneralUseCaseResponse
     */
    public function handle(
        SaveElementGeneralUseCaseArguments $arguments
    ) : SaveElementGeneralUseCaseResponse {
        try {
            $result = $this
                ->elementGeneralWriterRepository
                ->persist($arguments->getElementGeneral());

            if (empty($result)) {
                return new SaveElementGeneralUseCaseResponse(
                    false,
                    'An error has been occurred with database'
                );
            }

            return new SaveElementGeneralUseCaseResponse(
                true,
                null
            );
        } catch (ElementGeneralPersistException $e) {
            return new SaveElementGeneralUseCaseResponse(
                false,
                $e->getMessage()
            );
        }
    }
}
