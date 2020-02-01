<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailRequest;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailUseCase;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\ElementGeneralDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GeneralDetailController
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Controller
 * @author  Ismael Moral <jastertdc@gmailcom>
 */
final class GetElementGeneralDetailController
{
    /**
     * @var GetElementGeneralDetailUseCase
     */
    protected $getElementGeneralDetailUseCase;

    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    /**
     * @var ElementGeneralDataTransformer
     */
    protected $elementGeneralDataTransformer;

    /**
     * GetElementGeneralDetailController constructor.
     *
     * @param GetElementGeneralDetailUseCase $getElementGeneralDetailUseCase
     * @param TemplateRenderer $templateRenderer
     * @param ElementGeneralDataTransformer $elementGeneralDataTransformer
     */
    public function __construct(
        GetElementGeneralDetailUseCase $getElementGeneralDetailUseCase,
        TemplateRenderer $templateRenderer,
        ElementGeneralDataTransformer $elementGeneralDataTransformer
    ) {
        $this->getElementGeneralDetailUseCase = $getElementGeneralDetailUseCase;
        $this->templateRenderer = $templateRenderer;
        $this->elementGeneralDataTransformer = $elementGeneralDataTransformer;
    }

    /**
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
        $elementGeneralId = (int) $args['id'];

        $useCaseResponse = $this
            ->getElementGeneralDetailUseCase
            ->handle(
                new GetElementGeneralDetailRequest(
                    $elementGeneralId
                )
            );

        $templateData = [];

        if (!empty($useCaseResponse->getElementGeneral())) {
            $templateData = [
                'elementGeneral' => $this
                    ->elementGeneralDataTransformer
                    ->transform($useCaseResponse->getElementGeneral())
            ];
        }

        $html = $this
            ->templateRenderer
            ->getTemplateRenderer()
            ->render(
                'element_general_detail.html.twig',
                $templateData
            );

        $response->getBody()->write($html);
        $response = $response->withHeader('Content-type', 'html');

        return $response->withStatus(200);
    }
}
