<?php


namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * Class AddGeneralTorrentUseCaseArguments
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddGeneralTorrentUseCaseArguments
{
    /**
     * @var int
     */
    protected $elementGeneralId;

    /**
     * AddGeneralTorrentUseCaseArguments constructor.
     * @param int $elementGeneralId
     */
    public function __construct(int $elementGeneralId)
    {
        $this->elementGeneralId = $elementGeneralId;
    }

    /**
     * @return int
     */
    public function getElementGeneralId(): int
    {
        return $this->elementGeneralId;
    }
}
