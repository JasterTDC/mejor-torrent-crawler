<?php


namespace BestThor\ScrappingMaster\Application\Service;

use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailContentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailContentUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementDetail\RetrieveElementDetailUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementDownload\RetrieveElementDownloadContentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementDownload\RetrieveElementDownloadContentUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementDownload\RetrieveElementDownloadUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementDownload\RetrieveElementDownloadUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralContentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralContentUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementInFileUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\SaveElementInFileUseCaseArguments;
use BestThor\ScrappingMaster\Domain\ElementDetailContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneral;
use BestThor\ScrappingMaster\Domain\ElementGeneralCollection;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
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
     * @var SaveElementGeneralUseCase
     */
    protected $saveElementGeneralUseCase;

    /**
     * @var RetrieveElementGeneralContentUseCase
     */
    protected $retrieveElementGeneralContentUseCase;

    /**
     * @var RetrieveElementDetailContentUseCase
     */
    protected $retrieveElementDetailContentUseCase;

    /**
     * @var RetrieveElementDownloadContentUseCase
     */
    protected $retrieveElementDownloadContentUseCase;

    /**
     * RetrieveElementService constructor.
     * @param RetrieveElementGeneralUseCase $retrieveElementGeneralUseCase
     * @param RetrieveElementDetailUseCase $retrieveElementDetailUseCase
     * @param RetrieveElementDownloadUseCase $retrieveElementDownloadUseCase
     * @param MTContentReaderRepositoryInterface $mtContentReaderRepository
     * @param SaveElementInFileUseCase $saveElementInFileUseCase
     * @param SaveElementGeneralUseCase $saveElementGeneralUseCase
     * @param RetrieveElementGeneralContentUseCase $retrieveElementGeneralContentUseCase
     * @param RetrieveElementDetailContentUseCase $retrieveElementDetailContentUseCase
     * @param RetrieveElementDownloadContentUseCase $retrieveElementDownloadContentUseCase
     */
    public function __construct(
        RetrieveElementGeneralUseCase $retrieveElementGeneralUseCase,
        RetrieveElementDetailUseCase $retrieveElementDetailUseCase,
        RetrieveElementDownloadUseCase $retrieveElementDownloadUseCase,
        MTContentReaderRepositoryInterface $mtContentReaderRepository,
        SaveElementInFileUseCase $saveElementInFileUseCase,
        SaveElementGeneralUseCase $saveElementGeneralUseCase,
        RetrieveElementGeneralContentUseCase $retrieveElementGeneralContentUseCase,
        RetrieveElementDetailContentUseCase $retrieveElementDetailContentUseCase,
        RetrieveElementDownloadContentUseCase $retrieveElementDownloadContentUseCase
    ) {
        $this->retrieveElementGeneralUseCase = $retrieveElementGeneralUseCase;
        $this->retrieveElementDetailUseCase = $retrieveElementDetailUseCase;
        $this->retrieveElementDownloadUseCase = $retrieveElementDownloadUseCase;
        $this->mtContentReaderRepository = $mtContentReaderRepository;
        $this->saveElementInFileUseCase = $saveElementInFileUseCase;
        $this->saveElementGeneralUseCase = $saveElementGeneralUseCase;
        $this->retrieveElementGeneralContentUseCase = $retrieveElementGeneralContentUseCase;
        $this->retrieveElementDetailContentUseCase = $retrieveElementDetailContentUseCase;
        $this->retrieveElementDownloadContentUseCase = $retrieveElementDownloadContentUseCase;
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
            $retrieveElementGeneralUseCaseResponse = $this
                ->retrieveElementGeneralContentUseCase
                ->handle(
                    new RetrieveElementGeneralContentUseCaseArguments(
                        $argument->getPage()
                    )
                );

            if (!$retrieveElementGeneralUseCaseResponse->isSuccess() ||
                empty($retrieveElementGeneralUseCaseResponse->getContent())
            ) {
                throw new ElementGeneralContentEmptyException(
                    'We cannot retrieve element general content from source',
                    3
                );
            }

            $elementGeneralHtmlContent = $retrieveElementGeneralUseCaseResponse
                ->getContent();

            $retrieveElementGeneralUseCaseArgument = new RetrieveElementGeneralUseCaseArguments(
                empty($elementGeneralHtmlContent) ? null : $elementGeneralHtmlContent
            );
            $retrieveElementGeneralUseCaseResponse = $this
                ->retrieveElementGeneralUseCase
                ->handle($retrieveElementGeneralUseCaseArgument);

            if (!$retrieveElementGeneralUseCaseResponse->isSuccess() &&
                empty($retrieveElementGeneralUseCaseResponse->getElementGeneralCollection())
            ) {
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
                $elementGeneral = $this->retrieveElement(
                    $elementGeneral
                );

                if (!empty($elementGeneral)) {
                    $elementGeneralCollection->add($elementGeneral);
                }

                $this
                    ->saveElementGeneralUseCase
                    ->handle(
                        new SaveElementGeneralUseCaseArguments(
                            $elementGeneral
                        )
                    );
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

    /**
     * @param ElementGeneral $elementGeneral
     *
     * @return ElementGeneral|null
     */
    protected function retrieveElement(
        ElementGeneral $elementGeneral
    ) : ?ElementGeneral {
        try {
            $retrieveElementDetailContentUseCaseResponse = $this
                ->retrieveElementDetailContentUseCase
                ->handle(
                    new RetrieveElementDetailContentUseCaseArguments(
                        $elementGeneral
                    )
                );

            if (!$retrieveElementDetailContentUseCaseResponse->isSuccess() ||
                empty($retrieveElementDetailContentUseCaseResponse->getContent())
            ) {
                throw new ElementDetailContentEmptyException(
                    'We cannot extract element detail from the source',
                    3
                );
            }

            $elementDetailHtmlContent = $retrieveElementDetailContentUseCaseResponse
                ->getContent();

            $retrieveElementDetailUseCaseArguments = new RetrieveElementDetailUseCaseArguments(
                $elementDetailHtmlContent,
                $elementGeneral
            );
            $retrieveElementDetailUseCaseResponse = $this
                ->retrieveElementDetailUseCase
                ->handle($retrieveElementDetailUseCaseArguments);

            $elementGeneral = $retrieveElementDetailUseCaseResponse
                ->getElementGeneral();

            if (!empty($elementGeneral)) {
                $retrieveElementDownloadContentUseCaseResponse = $this
                    ->retrieveElementDownloadContentUseCase
                    ->handle(
                        new RetrieveElementDownloadContentUseCaseArguments(
                            $elementGeneral->getElementId()
                        )
                    );

                if (!$retrieveElementDownloadContentUseCaseResponse->isSuccess() ||
                    empty($retrieveElementDownloadContentUseCaseResponse->getContent())
                ) {
                    throw new ElementDownloadContentEmptyException(
                        'We cannot extract element download from the source',
                        3
                    );
                }

                $elementDownloadHtmlContent = $retrieveElementDownloadContentUseCaseResponse
                    ->getContent();

                $retrieveElementDownloadUseCaseArguments = new RetrieveElementDownloadUseCaseArguments(
                    $elementDownloadHtmlContent,
                    $elementGeneral
                );
                $retrieveElementDownloadUseCaseResponse = $this
                    ->retrieveElementDownloadUseCase
                    ->handle($retrieveElementDownloadUseCaseArguments);

                $elementGeneral = $retrieveElementDownloadUseCaseResponse
                    ->getElementGeneral();
            }

            if (!empty($elementGeneral) &&
                !empty($elementGeneral->getElementDownload())
            ) {
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
            }

            return $elementGeneral;
        } catch (\Exception $e) {
            return null;
        }
    }
}
