<?php

namespace BestThor\ScrappingMaster\Infrastructure\Transmission;

use BestThor\ScrappingMaster\Application\UseCase\Torrent\TorrentClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class TransmissionClient
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Transmission
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TransmissionClient implements TorrentClientInterface
{
    /**
     * Token header
     */
    public const TOKEN_HEADER = 'X-Transmission-Session-Id';

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * TransmissionClient constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param Client $client
     */
    public function __construct(
        string $host,
        int $port,
        string $username,
        string $password,
        Client $client
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;

        $this->baseUrl  = "{$this->host}:{$this->port}/transmission/rpc";
        $this->client   = $client;
        $this->token    = '';
    }

    /**
     * @param string $fileContent
     *
     * @return array
     */
    public function add(string $fileContent): array
    {
        return $this->call([
            'method'    => 'torrent-add',
            'arguments' => [
                'metainfo'  => base64_encode($fileContent)
            ]
        ]);
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function call(
        array $arguments
    ): array {

        try {
            $response = $this->client->request('POST', $this->baseUrl, [
                'auth'  => [
                    $this->username,
                    $this->password
                ],
                'headers' => [
                    self::TOKEN_HEADER => $this->token
                ],
                'json' => $arguments
            ]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            if (
                !empty($e->getResponse()) &&
                409 == $e->getResponse()->getStatusCode()
            ) {
                $tokenValue = $e
                    ->getResponse()
                    ->getHeader(self::TOKEN_HEADER);

                if (
                    $tokenValue === (array) $tokenValue &&
                    !empty($tokenValue)
                ) {
                    $this->token = $tokenValue[0];
                }

                return $this->call($arguments);
            }
        }

        return [];
    }
}
