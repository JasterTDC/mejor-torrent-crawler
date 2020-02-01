<?php

namespace BestThor\ScrappingMaster\Infrastructure\Bot;

use BestThor\ScrappingMaster\Domain\Notification\NotificationServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class TelegramRequest
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Bot
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TelegramRequest implements NotificationServiceInterface
{
    // Get method
    private const GET_METHOD = 'GET';

    // Post method
    private const POST_METHOD = 'POST';

    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var Client
     */
    protected $client;

    /**
     * TelegramRequest constructor.
     *
     * @param string $apiToken
     * @param string $baseUrl
     */
    public function __construct(
        string $apiToken,
        string $baseUrl
    ) {
        $this->apiToken = $apiToken;
        $this->baseUrl = $baseUrl;

        $this->client = new Client([
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * Get bot information
     *
     * @return  array
     */
    public function getMe(): array
    {
        return $this->call(
            "/bot{$this->apiToken}/getMe",
            self::GET_METHOD
        );
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function sendMessage(array $parameters): array
    {
        return $this->call(
            "/bot{$this->apiToken}/sendMessage",
            self::POST_METHOD,
            $parameters
        );
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function sendPhoto(array $parameters): array
    {
        return $this->call(
            "/bot{$this->apiToken}/sendPhoto",
            self::POST_METHOD,
            $parameters
        );
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $json
     *
     * @return array
     */
    protected function call(
        string $url,
        string $method = 'GET',
        array $json = []
    ): array {

        try {
            $response = $this
                ->client
                ->request($method, $url, [
                    'headers' => [
                        'Content-type' => 'application/json'
                    ],
                    'json' => $json
                ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
