<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RetrieveElementGeneralCollectionController
 * 
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralCollectionController
{

    /** @var RetrieveElementGeneralCollectionUseCase */
    protected $useCase;

    /** @var ElementGeneralCollectionDataTransformer */
    protected $elementGeneralDataTransformer;

    /** @var TemplateRenderer */
    protected $templateRenderer;

    /**
     * RetrieveElementGeneralCollectionController
     *
     * @param RetrieveElementGeneralCollectionUseCase $useCase
     * @param ElementGeneralCollectionDataTransformer $dataTransformer
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        RetrieveElementGeneralCollectionUseCase $useCase,
        ElementGeneralCollectionDataTransformer $dataTransformer,
        TemplateRenderer $templateRenderer
    ) {
        $this->useCase = $useCase;
        $this->elementGeneralDataTransformer = $dataTransformer;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * RetrieveElementGeneralCollectionController
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ) : ResponseInterface {
        $page = (int) $args['page'];

        $useCaseResponse = $this
            ->useCase
            ->handle(
                new RetrieveElementGeneralCollectionUseCaseArguments(
                    $page,
                    50
                )
            );

        $res['success'] = $useCaseResponse->getSuccess();

        if (!empty($useCaseResponse->getElementGeneralCollection())) {
            $res['elementGeneralCollection'] = $this
                ->elementGeneralDataTransformer
                ->transform(
                    $useCaseResponse->getElementGeneralCollection()
                );
        }

        $html = $this
            ->templateRenderer
            ->getTemplateRenderer()
            ->render('element_general.html.twig', $res);

        $response
            ->getBody()
            ->write($html);

        $response = $response
            ->withHeader('Content-type', 'text/html');

        return $response
            ->withStatus(200);
    }
}
