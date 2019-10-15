<?php


namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\ElementDetailContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class GuzzleMTContentReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GuzzleMTContentReaderRepository
    implements MTContentReaderRepositoryInterface
{

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $generalUrl;

    /**
     * @var string
     */
    protected $downloadUrl;

    /**
     * GuzzleMTContentReaderRepository constructor.
     *
     * @param string $baseUrl
     * @param string $generalUrl
     * @param string $downloadUrl
     */
    public function __construct(
        string $baseUrl,
        string $generalUrl,
        string $downloadUrl
    ) {
        $this->baseUrl      = $baseUrl;
        $this->generalUrl   = $generalUrl;
        $this->downloadUrl  = $downloadUrl;

        $this->httpClient = new Client([
            'base_uri'  => $this->baseUrl
        ]);
    }

    /**
     * @param string $detailUrl
     *
     * @return string
     * @throws ElementDetailContentEmptyException
     */
    public function getElementDetailContent(
        string $detailUrl
    ) : string {
        try {
            $response = $this->httpClient->get($detailUrl);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementDetailContentEmptyException(
                'We could not retrieve detail content',
                1
            );
        }
    }

    /**
     * @param int $page
     *
     * @return string
     * @throws ElementGeneralContentEmptyException
     */
    public function getElementGeneralContent(
        int $page
    ) : string {
        $elementGeneralUrl = sprintf(
            $this->generalUrl,
            $page
        );

        try {
            $response = $this->httpClient->get($elementGeneralUrl);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementGeneralContentEmptyException(
                'We could not retrieve general content',
                1
            );
        }
    }

    /**
     * @param int $elementId
     *
     * @return string
     * @throws ElementDownloadContentEmptyException
     */
    public function getElementDownloadContent(
        int $elementId
    ) : string {
        $elementDownloadUrl = sprintf(
            $this->downloadUrl,
            $elementId
        );

        try {
            $response = $this->httpClient->get($elementDownloadUrl);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementDownloadContentEmptyException(
                'We could not retrieve download content',
                1
            );
        }
    }

    /**
     * @param int $elementId
     *
     * @return string
     */
    public function getElementDownloadUrl(
        int $elementId
    ) : string {
        return sprintf(
            $this->downloadUrl,
            $elementId
        );
    }
}
