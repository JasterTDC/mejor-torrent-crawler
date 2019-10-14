<?php


namespace BestThor\ScrappingMaster\Application\UseCase;

use BestThor\ScrappingMaster\Domain\ElementGeneralParserInterface;

/**
 * Class RetrieveElementGeneralUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralUseCase
{

    /**
     * @var ElementGeneralParserInterface
     */
    protected $elementGeneralParser;

    /**
     * RetrieveElementGeneralUseCase constructor.
     *
     * @param ElementGeneralParserInterface $elementGeneralParser
     */
    public function __construct(ElementGeneralParserInterface $elementGeneralParser)
    {
        $this->elementGeneralParser = $elementGeneralParser;
    }

    /**
     * @param RetrieveElementGeneralUseCaseArguments $argument
     *
     * @return RetrieveElementGeneralUseCaseResponse
     */
    public function handle(
        RetrieveElementGeneralUseCaseArguments $argument
    ) : RetrieveElementGeneralUseCaseResponse {
        if (empty($argument->getContent())) {
            return new RetrieveElementGeneralUseCaseResponse(
                false,
                null,
                'Content cannot be empty'
            );
        }

        $this->elementGeneralParser->setContent($argument->getContent());

        try {
            $elementGeneralCollection = $this
                ->elementGeneralParser
                ->getElementGeneral();

            if (empty($elementGeneralCollection)) {
                return new RetrieveElementGeneralUseCaseResponse(
                    false,
                    null,
                    'ElementGeneralCollection is empty'
                );
            }

            return new RetrieveElementGeneralUseCaseResponse(
                true,
                $elementGeneralCollection,
                null
            );
        } catch (\Exception $e) {
            return new RetrieveElementGeneralUseCaseResponse(
                false,
                null,
                $e->getMessage()
            );
        }
    }
}
