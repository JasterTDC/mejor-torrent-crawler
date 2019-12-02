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

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        $res = [
            'success' => false
        ];

        $parameters = json_decode($request->getBody(), true);

        if (empty($parameters['elementGeneralId'])) {
            $response->getBody()->write(json_encode($res));

            return $response->withStatus(400);
        }

        $useCaseResponse = $this
            ->useCase
            ->handle(
                new AddGeneralTorrentUseCaseArguments(
                    (int) $parameters['elementGeneralId']
                )
            );

        $res['success'] = $useCaseResponse->isSuccess();

        $response->getBody()->write(json_encode($res));

        return $response->withStatus(200);
    }
}
