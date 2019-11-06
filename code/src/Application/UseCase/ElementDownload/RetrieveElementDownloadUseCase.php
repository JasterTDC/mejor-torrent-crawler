<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDownload;

use BestThor\ScrappingMaster\Domain\ElementDownloadParserInterface;

/**
 * Class RetrieveElementDownloadUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDownloadUseCase
{

    /**
     * @var ElementDownloadParserInterface
     */
    protected $elementDownloadParser;

    /**
     * RetrieveElementDownloadUseCase constructor.
     *
     * @param ElementDownloadParserInterface $elementDownloadParser
     */
    public function __construct(
        ElementDownloadParserInterface $elementDownloadParser
    ) {
        $this->elementDownloadParser = $elementDownloadParser;
    }

    /**
     * @param RetrieveElementDownloadUseCaseArguments $argument
     *
     * @return RetrieveElementDownloadUseCaseResponse
     */
    public function handle(
        RetrieveElementDownloadUseCaseArguments $argument
    ) : RetrieveElementDownloadUseCaseResponse {
        if (empty($argument->getContent())) {
            return new RetrieveElementDownloadUseCaseResponse(
                false,
                'Content cannot be empty',
                null
            );
        }

        if (empty($argument->getElementGeneral())) {
            return new RetrieveElementDownloadUseCaseResponse(
                false,
                'ElementGeneral cannot be empty',
                null
            );
        }

        try {
            $elementGeneral = $argument->getElementGeneral();

            $this
                ->elementDownloadParser
                ->setContent($argument->getContent());

            $elementDownload = $this
                ->elementDownloadParser
                ->getElementDownload();

            $elementGeneral->setElementDownload(
                $elementDownload
            );

            return new RetrieveElementDownloadUseCaseResponse(
                true,
                null,
                $elementGeneral
            );
        } catch (\Exception $e) {
            return new RetrieveElementDownloadUseCaseResponse(
                false,
                $e->getMessage(),
                null
            );
        }
    }
}
