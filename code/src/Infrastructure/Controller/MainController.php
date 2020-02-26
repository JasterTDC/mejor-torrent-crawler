<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\General\ElementGeneralCollectionDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\Series\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class MainController
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Controller
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MainController
{
    /**
     * @var GetElementUseCase
     */
    protected $getElementUseCase;

    /**
     * @var ElementSeriesDataTransformer
     */
    protected $elementSeriesDataTransformer;

    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    /**
     * MainController constructor.
     *
     * @param GetElementUseCase $getElementUseCase
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        GetElementUseCase $getElementUseCase,
        ElementSeriesDataTransformer $elementSeriesDataTransformer,
        TemplateRenderer $templateRenderer
    ) {
        $this->getElementUseCase = $getElementUseCase;
        $this->elementSeriesDataTransformer = $elementSeriesDataTransformer;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $useCaseResponse = $this
            ->getElementUseCase
            ->handle(
                new GetElementUseCaseArguments(
                    1,
                    20
                )
            );

        if (
            empty($useCaseResponse->isSuccess()) ||
            empty($useCaseResponse->getElementGeneralCollection()) ||
            empty($useCaseResponse->getElementSeriesCollection())
        ) {
            return $response->withStatus(404);
        }

        $dataTransformer = new ElementGeneralCollectionDataTransformer();

        try {
            $elementGeneralCollectionTransformed = $dataTransformer
                ->transform($useCaseResponse->getElementGeneralCollection());

            $elementSeriesCollectionTransformed = $this
                ->elementSeriesDataTransformer
                ->transformCollection($useCaseResponse->getElementSeriesCollection());

            $html = $this
                ->templateRenderer
                ->getTemplateRenderer()
                ->render(
                    'main.html.twig',
                    [
                        'elementGeneralCollection'  => $elementGeneralCollectionTransformed,
                        'elementSeriesCollection'   => $elementSeriesCollectionTransformed,
                        'homeActive' => true
                    ]
                );

            $response->getBody()->write($html);
            $response = $response->withHeader('Content-type', 'text/html');

            return $response->withStatus(200);
        } catch (\Exception $e) {
        }

        return $response->withStatus(200);
    }
}
