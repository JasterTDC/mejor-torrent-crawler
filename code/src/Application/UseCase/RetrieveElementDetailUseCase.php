<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementDetailParserInterface;

/**
 * Class RetrieveElementDetailUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDetailUseCase
{

    /**
     * @var ElementDetailParserInterface
     */
    protected $elementDetailParser;

    /**
     * RetrieveElementDetailUseCase constructor.
     *
     * @param ElementDetailParserInterface $elementDetailParser
     */
    public function __construct(
        ElementDetailParserInterface $elementDetailParser
    ) {
        $this->elementDetailParser = $elementDetailParser;
    }

    /**
     * @param RetrieveElementDetailUseCaseArguments $argument
     *
     * @return RetrieveElementDetailUseCaseResponse
     */
    public function handle(
        RetrieveElementDetailUseCaseArguments $argument
    ) : RetrieveElementDetailUseCaseResponse {
        if (empty($argument->getContent())) {
            return new RetrieveElementDetailUseCaseResponse(
                false,
                'Content cannot be empty',
                null
            );
        }

        if (empty($argument->getElementGeneral())) {
            return new RetrieveElementDetailUseCaseResponse(
                false,
                'ElementGeneral cannot be empty',
                null
            );
        }

        try {
            $this
                ->elementDetailParser
                ->setContent(
                    $argument->getContent()
                );

            $elementDetail = $this
                ->elementDetailParser
                ->getElementDetail();

            $elementDetail = $elementDetail->setElementDir(
                $elementDetail->getElementDir() .
                $argument->getElementGeneral()->getElementName()
            );

            $elementGeneral = $argument
                ->getElementGeneral();

            $elementGeneral
                ->setElementDetail($elementDetail);

            return new RetrieveElementDetailUseCaseResponse(
                true,
                null,
                $elementGeneral
            );
        } catch (\Exception $e) {
            return new RetrieveElementDetailUseCaseResponse(
                false,
                $e->getMessage(),
                null
            );
        }
    }
}
