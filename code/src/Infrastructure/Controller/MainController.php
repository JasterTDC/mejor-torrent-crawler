<?php

namespace BestThor\ScrappingMaster\Infrastructure\Controller;

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
     * MainController constructor.
     */
    public function __construct()
    {
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
        $response->getBody()->write(json_encode([
            'success'   => true
        ]));
        $response = $response->withHeader('Content-type', 'application/json');

        return $response->withStatus(200);
    }
}
