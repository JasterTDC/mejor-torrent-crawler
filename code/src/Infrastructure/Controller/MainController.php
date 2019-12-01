<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralCollectionDataTransformer;
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
     * @var GetElementGeneralUseCase
     */
    protected $getElementGeneralUseCase;

    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    /**
     * MainController constructor.
     *
     * @param GetElementGeneralUseCase $getElementGeneralUseCase
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        GetElementGeneralUseCase $getElementGeneralUseCase,
        TemplateRenderer $templateRenderer
    ) {
        $this->getElementGeneralUseCase = $getElementGeneralUseCase;
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
    ) : ResponseInterface {
        $useCaseResponse = $this
            ->getElementGeneralUseCase
            ->handle(
                new GetElementGeneralUseCaseArguments(
                    20,
                    1
                )
            );

        if ($useCaseResponse->isSuccess() &&
            !empty($useCaseResponse->getElementGeneralCollection())
        ) {
            $dataTransformer = new ElementGeneralCollectionDataTransformer();

            try {
                $elementGeneralCollectionTransformed = $dataTransformer
                    ->transform($useCaseResponse->getElementGeneralCollection());

                $html = $this
                    ->templateRenderer
                    ->getTemplateRenderer()
                    ->render(
                        'main.html.twig',
                        [
                            'elementGeneralCollection' => $elementGeneralCollectionTransformed
                        ]
                    );

                $response->getBody()->write($html);
                $response = $response->withHeader('Content-type', 'text/html');

                return $response->withStatus(200);
            } catch (\Exception $e) {
            }
        }

        return $response->withStatus(200);
    }
}
