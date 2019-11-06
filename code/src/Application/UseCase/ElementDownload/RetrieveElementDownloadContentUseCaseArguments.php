<?php


namespace BestThor\ScrappingMaster\Application\UseCase\ElementDownload;

/**
 * Class RetrieveElementDownloadContentUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementDownload
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementDownloadContentUseCaseArguments
{

    /**
     * @var int
     */
    protected $elementId;

    /**
     * RetrieveElementDownloadContentUseCaseArguments constructor.
     *
     * @param int $elementId
     */
    public function __construct(
        int $elementId
    ) {
        $this->elementId = $elementId;
    }

    /**
     * @return int
     */
    public function getElementId(): int
    {
        return $this->elementId;
    }
}
