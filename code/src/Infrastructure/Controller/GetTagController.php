<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\Tag\GetTagUseCase;
use BestThor\ScrappingMaster\Infrastructure\DataTransformer\GetTagDataTransformer;
use BestThor\ScrappingMaster\Infrastructure\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class GetTagController
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Controller
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetTagController
{

    /** @var GetTagUseCase */
    protected GetTagUseCase $useCase;

    /** @var TemplateRenderer */
    protected TemplateRenderer $templateRenderer;

    /** @var GetTagDataTransformer */
    protected GetTagDataTransformer $transformer;

    /**
     * GetTagController constructor.
     *
     * @param GetTagUseCase $useCase
     * @param TemplateRenderer $templateRenderer
     * @param GetTagDataTransformer $transformer
     */
    public function __construct(
        GetTagUseCase $useCase,
        TemplateRenderer $templateRenderer,
        GetTagDataTransformer $transformer
    ) {
        $this->useCase = $useCase;
        $this->templateRenderer = $templateRenderer;
        $this->transformer = $transformer;
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

        $html = $this
            ->templateRenderer
            ->getTemplateRenderer()
            ->render(
                'tag.html.twig',
                $this->getTemplateData()
            );

        $response = $response->withHeader('Content-type', 'text/html');
        $response->getBody()->write($html);

        return $response->withStatus(200);
    }

    /**
     * @return array
     */
    protected function getTemplateData(): array
    {
        $response = $this->useCase->handle();

        if (empty($response->getTagCollection())) {
            return [];
        }

        return $this
            ->transformer
            ->transform(
                $response->getTagCollection()
            );
    }
}
