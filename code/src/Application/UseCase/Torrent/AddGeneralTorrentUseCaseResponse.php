<?php


namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * Class AddGeneralTorrentUseCaseResponse
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddGeneralTorrentUseCaseResponse
{

    /**
     * @var bool
     */
    protected $success;

    /**
     * AddGeneralTorrentUseCaseResponse constructor.
     * @param bool $success
     */
    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }
}
