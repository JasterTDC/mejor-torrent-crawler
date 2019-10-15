<?php


namespace BestThor\ScrappingMaster\Application\Service;

use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDetailUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDownloadUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementDownloadUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\RetrieveElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\SaveElementInFileUseCase;
use BestThor\ScrappingMaster\Application\UseCase\SaveElementInFileUseCaseArguments;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;

/**
 * Class RetrieveElementService
 *
 * @package BestThor\ScrappingMaster\Application\Service
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementService
{

    /**
     * @var RetrieveElementGeneralUseCase
     */
    protected $retrieveElementGeneralUseCase;

    /**
     * @var RetrieveElementDetailUseCase
     */
    protected $retrieveElementDetailUseCase;

    /**
     * @var RetrieveElementDownloadUseCase
     */
    protected $retrieveElementDownloadUseCase;

    /**
     * @var SaveElementInFileUseCase
     */
    protected $saveElementInFileUseCase;

    /**
     * @var MTContentReaderRepositoryInterface
     */
    protected $mtContentReaderRepository;

    /**
     * RetrieveElementService constructor.
     * @param RetrieveElementGeneralUseCase $retrieveElementGeneralUseCase
     * @param RetrieveElementDetailUseCase $retrieveElementDetailUseCase
     * @param RetrieveElementDownloadUseCase $retrieveElementDownloadUseCase
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param SaveElementInFileUseCase $saveElementInFileUseCase
     */
    public function __construct(
        RetrieveElementGeneralUseCase $retrieveElementGeneralUseCase,
        RetrieveElementDetailUseCase $retrieveElementDetailUseCase,
        RetrieveElementDownloadUseCase $retrieveElementDownloadUseCase,
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        SaveElementInFileUseCase $saveElementInFileUseCase
    ) {
        $this->retrieveElementGeneralUseCase = $retrieveElementGeneralUseCase;
        $this->retrieveElementDetailUseCase = $retrieveElementDetailUseCase;
        $this->retrieveElementDownloadUseCase = $retrieveElementDownloadUseCase;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->saveElementInFileUseCase = $saveElementInFileUseCase;
    }

    /**
     * @param RetrieveElementServiceArguments $argument
     *
     * @return RetrieveElementServiceResponse
     */
    public function handle(
        RetrieveElementServiceArguments $argument
    ) : RetrieveElementServiceResponse {

        try {
            $elementGeneralHtmlContent = $this
                ->mtContentReaderRepository
                ->getElementGeneralContent(1);

            $retrieveElementGeneralUseCaseArgument = new RetrieveElementGeneralUseCaseArguments(
                empty($elementGeneralHtmlContent) ? null : $elementGeneralHtmlContent
            );
            $retrieveElementGeneralUseCaseResponse = $this
                ->retrieveElementGeneralUseCase
                ->handle($retrieveElementGeneralUseCaseArgument);

            if (!$retrieveElementGeneralUseCaseResponse->isSuccess() &&
                empty($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection())) {

                return new RetrieveElementServiceResponse(
                    false,
                    'We could not retrieve element general information',
                    null
                );
            }

            $elementGeneralCollection = new ElementGeneralCollection();

            if (empty($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection())) {
                return new RetrieveElementServiceResponse(
                    false,
                    'We could not retrieve a valid ElementGeneral collection',
                    null
                );
            }

            /** @var ElementGeneral $elementGeneral */
            foreach ($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection() as $elementGeneral) {
                $elementDetailHtmlContent = $this
                    ->mtContentReaderRepository
                    ->getElementDetailContent($elementGeneral->getElementLink());

                $retrieveElementDetailUseCaseArguments = new RetrieveElementDetailUseCaseArguments(
                    empty($elementDetailHtmlContent) ? null : $elementDetailHtmlContent,
                    $elementGeneral
                );
                $retrieveElementDetailUseCaseResponse = $this
                    ->retrieveElementDetailUseCase
                    ->handle($retrieveElementDetailUseCaseArguments);

                $elementGeneral = $retrieveElementDetailUseCaseResponse
                    ->getElementGeneral();

                $elementDownloadHtmlContent = $this
                    ->mtContentReaderRepository
                    ->getElementDownloadContent($elementGeneral->getElementId());

                $retrieveElementDownloadUseCaseArguments = new RetrieveElementDownloadUseCaseArguments(
                    empty($elementDownloadHtmlContent) ? null : $elementDownloadHtmlContent,
                    $elementGeneral
                );
                $retrieveElementDownloadUseCaseResponse = $this
                    ->retrieveElementDownloadUseCase
                    ->handle($retrieveElementDownloadUseCaseArguments);

                $elementGeneral = $retrieveElementDownloadUseCaseResponse
                    ->getElementGeneral();

                $elementGeneral->setElementDownload(
                    $elementGeneral->getElementDownload()->setElementDownloadUrl(
                        $this
                            ->mtContentReaderRepository
                            ->getElementDownloadUrl(
                                $elementGeneral->getElementId()
                            )
                    )
                );

                $this->saveElementInFileUseCase->handle(
                    new SaveElementInFileUseCaseArguments(
                        $elementGeneral
                    )
                );

                $elementGeneralCollection->add($elementGeneral);
            }

            return new RetrieveElementServiceResponse(
                true,
                null,
                $elementGeneralCollection
            );
        } catch (\Exception $e) {
            return new RetrieveElementServiceResponse(
                false,
                $e->getMessage(),
                null
            );
        }
    }
}
