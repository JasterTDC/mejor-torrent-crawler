<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

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
    ) : ResponseInterface {
        $res = [
            'success' => false
        ];

        $parameters = json_decode($request->getBody(), true);

        if (empty($parameters['elementSeriesId'])) {
            $response->getBody()->write(json_encode($res));

            return $response->withStatus(400);
        }

        if (empty($parameters['elementSeriesName'])) {
            $response->getBody()->write(json_encode($res));

            return $response->withStatus(400);
        }

        $useCaseResponse = $this->useCase->handle(
            new AddSeriesTorrentUseCaseArguments(
                (int) $parameters['elementSeriesId'],
                $parameters['elementSeriesName']
            )
        );

        $res['success'] = $useCaseResponse->getSuccess();

        $response->getBody()->write(json_encode($res));

        return $response->withStatus(200);
    }
}
