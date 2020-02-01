<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\ElementDetailContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementDownloadContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralContentEmptyException;
use BestThor\ScrappingMaster\Domain\ElementImageEmptyException;
use BestThor\ScrappingMaster\Domain\MTContentReaderRepositoryInterface;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailEmptyException;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class GuzzleMTContentReaderRepository
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GuzzleMTContentReaderRepository implements
    MTContentReaderRepositoryInterface
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
    protected $seriesUrl;

    /**
     * @var string
     */
    protected $seriesDownloadUrl;

    /**
     * @var string
     */
    protected $downloadUrl;

    /**
     * GuzzleMTContentReaderRepository constructor.
     * @param string $baseUrl
     * @param string $generalUrl
     * @param string $seriesUrl
     * @param string $downloadUrl
     * @param string $seriesDownloadUrl
     */
    public function __construct(
        string $baseUrl,
        string $generalUrl,
        string $seriesUrl,
        string $downloadUrl,
        string $seriesDownloadUrl
    ) {
        $this->baseUrl      = $baseUrl;
        $this->generalUrl   = $generalUrl;
        $this->downloadUrl  = $downloadUrl;
        $this->seriesUrl    = $seriesUrl;
        $this->seriesDownloadUrl = $seriesDownloadUrl;

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
    ): string {
        try {
            $response = $this->httpClient->get($detailUrl);

            return (string) $response->getBody();
        } catch (\Exception $e) {
            throw new ElementDetailContentEmptyException(
                'We could not retrieve detail content',
                1
            );
        }
    }

    /**
     * @param string $imageUrl
     *
     * @return string
     * @throws ElementImageEmptyException
     */
    public function getElementImageFile(
        ?string $imageUrl
    ): string {
        if (empty($imageUrl)) {
            throw new ElementImageEmptyException(
                'We need a valid image path',
                0
            );
        }

        try {
            $response = $this->httpClient->get($imageUrl);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new ElementImageEmptyException(
                'We could not retrieve the poster',
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
    ): string {
        $elementGeneralUrl = sprintf(
            $this->generalUrl,
            $page
        );

        try {
            $response = $this->httpClient->get($elementGeneralUrl);

            return (string) $response->getBody();
        } catch (\Exception $e) {
            throw new ElementGeneralContentEmptyException(
                'We could not retrieve general content',
                1
            );
        }
    }

    /**
     * @param int $page
     *
     * @return string
     * @throws ElementSeriesEmptyException
     */
    public function getElementSeriesContent(
        int $page
    ): string {
        $elementSeriesUrl = sprintf(
            $this->seriesUrl,
            $page
        );

        try {
            $response = $this->httpClient->get($elementSeriesUrl);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementSeriesEmptyException(
                'ElementSeriesContent. We could not retrieve series content',
                1
            );
        }
    }

    /**
     * @param string $detailUrl
     *
     * @return string
     * @throws ElementSeriesDetailEmptyException
     */
    public function getElementSeriesDetailContent(
        string $detailUrl
    ): string {
        try {
            $response = $this->httpClient->get($detailUrl);

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementSeriesDetailEmptyException(
                'ElementSeriesDetailContent. We could not retrieve detail content',
                1
            );
        }
    }

    /**
     * @param int $episodeId
     * @return string
     * @throws ElementSeriesDetailEmptyException
     */
    public function getElementSeriesDownloadContent(
        int $episodeId
    ): string {
        try {
            $response = $this->httpClient->get(sprintf($this->seriesDownloadUrl, $episodeId));

            return (string) $response->getBody();
        } catch (ClientException $e) {
            throw new ElementSeriesDetailEmptyException(
                'ElementSeriesDetailContent. We could not retrieve detail content',
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
    ): string {
        $elementDownloadUrl = sprintf(
            $this->downloadUrl,
            $elementId
        );

        try {
            $response = $this->httpClient->get($elementDownloadUrl);

            return (string) $response->getBody();
        } catch (\Exception $e) {
            throw new ElementDownloadContentEmptyException(
                'We could not retrieve download content',
                1
            );
        }
    }

    /**
     * @param string $downloadPath
     *
     * @return string
     * @throws ElementDownloadContentEmptyException
     */
    public function getElementDownloadFile(
        string $downloadPath
    ): string {
        try {
            $response = $this->httpClient->get($downloadPath);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new ElementDownloadContentEmptyException(
                '[MTContentReaderRepository][ElementDownloadFile] ' . $e->getMessage(),
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
    ): string {
        return sprintf(
            $this->downloadUrl,
            $elementId
        );
    }
}
