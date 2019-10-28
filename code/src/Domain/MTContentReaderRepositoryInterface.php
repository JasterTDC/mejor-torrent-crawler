<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Interface MTContentReaderRepositoryInterface
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface MTContentReaderRepositoryInterface
{

    /**
     * @param string $detailUrl
     *
     * @return string
     * @throws ElementDetailContentEmptyException
     */
    public function getElementDetailContent(
        string $detailUrl
    ) : string;

    /**
     * @param int $page
     *
     * @return string
     * @throws ElementGeneralContentEmptyException
     */
    public function getElementGeneralContent(
        int $page
    ) : string;

    /**
     * @param int $elementId
     *
     * @return string
     * @throws ElementDownloadContentEmptyException
     */
    public function getElementDownloadContent(
        int $elementId
    ) : string;

    /**
     * @param int $elementId
     *
     * @return string
     */
    public function getElementDownloadUrl(
        int $elementId
    ) : string;

    /**
     * @param string $downloadPath
     *
     * @return string
     * @throws ElementDownloadContentEmptyException
     */
    public function getElementDownloadFile(
        string $downloadPath
    ) : string;

    /**
     * @param string $imageUrl
     *
     * @return string
     * @throws ElementImageEmptyException
     */
    public function getElementImageFile(
        string $imageUrl
    ) : string;
}
