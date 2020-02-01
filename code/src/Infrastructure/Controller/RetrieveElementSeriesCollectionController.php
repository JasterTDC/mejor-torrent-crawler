<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementSeriesDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RetrieveElementSeriesCollectionController class
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementSeriesCollectionController
{
    /**
     * Series route
     */
    public const RETRIEVE_ELEMENT_ROUTE = '/series/get/';

    /** @var RetrieveElementSeriesCollectionUseCase $useCase */
    protected $useCase;

    /** @var ElementSeriesDataTransformer $transformer */
    protected $transformer;

    /** @var TemplateRenderer $templateRenderer */
    protected $templateRenderer;

    /**
     * RetrieveElementSeriesCollectionController controller
     *
     * @param RetrieveElementSeriesCollectionUseCase $useCase
     * @param ElementSeriesDataTransformer $transformer
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        RetrieveElementSeriesCollectionUseCase $useCase,
        ElementSeriesDataTransformer $transformer,
        TemplateRenderer $templateRenderer
    ) {
        $this->useCase = $useCase;
        $this->transformer = $transformer;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * RetrieveElementSeriesCollectionController callable
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
    ): ResponseInterface {
        $res['success'] = true;

        $page = (int) $args['page'];

        $useCaseResponse = $this
            ->useCase
            ->handle(
                new RetrieveElementSeriesCollectionUseCaseArguments(
                    $page,
                    50
                )
            );

        $res['seriesActive'] = true;

        if (!empty($useCaseResponse->getElementSeriesCollection())) {
            $res['elementSeriesCollection'] = $this
                ->transformer
                ->transformCollection(
                    $useCaseResponse->getElementSeriesCollection()
                );
        }

        if (!empty($useCaseResponse->getNextPage())) {
            $res['nextPage'] = self::RETRIEVE_ELEMENT_ROUTE . $useCaseResponse
                ->getNextPage();
        }

        if (!empty($useCaseResponse->getPreviousPage())) {
            $res['previousPage'] = self::RETRIEVE_ELEMENT_ROUTE . $useCaseResponse
                ->getPreviousPage();
        }

        $html = $this
            ->templateRenderer
            ->getTemplateRenderer()
            ->render('element_series.html.twig', $res);

        $response
            ->getBody()
            ->write($html);

        $response = $response
            ->withHeader('Content-type', 'text/html');

        return $response
            ->withStatus(200);
    }
}
