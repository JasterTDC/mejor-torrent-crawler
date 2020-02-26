<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller\Series;

use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddSeriesTorrentUseCaseArguments;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * AddSeriesTorrentController class
 *
 * @author Ismael Moral <jastertdc@gmai.com>
 */
final class AddSeriesTorrentController
{

    /**
     * AddSeriesTorrentUseCase
     *
     * @var AddSeriesTorrentUseCase
     */
    private $useCase;

    /**
     * AddSeriesTorrentController constructor
     *
     * @param AddSeriesTorrentUseCase $addSeriesTorrentUseCase
     */
    public function __construct(
        AddSeriesTorrentUseCase $addSeriesTorrentUseCase
    ) {
        $this->useCase = $addSeriesTorrentUseCase;
    }

    /**
     * AddSeriesTorrentController call
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $res = [
            'success' => false
        ];

        $parameters = json_decode($request->getBody(), true);

        if (empty($parameters['elementSeriesId'])) {
            return $this->getResponse($response, $res, 400);
        }

        if (empty($parameters['elementSeriesName'])) {
            return $this->getResponse($response, $res, 400);
        }

        $useCaseResponse = $this->useCase->handle(
            new AddSeriesTorrentUseCaseArguments(
                $parameters['elementSeriesName']
            )
        );

        $res['success'] = $useCaseResponse->getSuccess();

        return $this->getResponse($response, $res, 200);
    }

    /**
     * @param ResponseInterface $response
     * @param array $res
     * @param int $statusCode
     *
     * @return ResponseInterface
     */
    protected function getResponse(
        ResponseInterface $response,
        array $res,
        int $statusCode = 400
    ): ResponseInterface {
        $encodedRes = json_encode($res);

        if (empty($encodedRes)) {
            return $response->withStatus($statusCode);
        }

        $response->getBody()->write($encodedRes);

        return $response->withStatus($statusCode);
    }
}
