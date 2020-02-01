<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCase;
use BestThor\ScrappingMaster\Application\UseCase\Torrent\AddGeneralTorrentUseCaseArguments;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AddGeneralTorrentController
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Controller
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddGeneralTorrentController
{
    /**
     * @var AddGeneralTorrentUseCase
     */
    protected $useCase;

    /**
     * AddGeneralTorrentController constructor.
     *
     * @param AddGeneralTorrentUseCase $useCase
     */
    public function __construct(
        AddGeneralTorrentUseCase $useCase
    ) {
        $this->useCase = $useCase;
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
        $res = [
            'success' => false
        ];

        $parameters = json_decode($request->getBody(), true);

        if (empty($parameters['elementGeneralId'])) {
            return $this->getResponse($response, $res, 400);
        }

        $useCaseResponse = $this
            ->useCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    (int) $parameters['elementGeneralId']
                )
            );

        $res['success'] = $useCaseResponse->isSuccess();

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
