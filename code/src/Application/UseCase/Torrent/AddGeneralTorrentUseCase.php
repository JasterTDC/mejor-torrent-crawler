<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * Class AddGeneralTorrentUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class AddGeneralTorrentUseCase
{
    /**
     * @var TorrentClientInterface
     */
    protected $torrentClient;

    /**
     * @var string
     */
    protected $staticDir;

    /**
     * AddGeneralTorrentUseCase constructor.
     * @param TorrentClientInterface $torrentClient
     * @param string $staticDir
     */
    public function __construct(
        TorrentClientInterface $torrentClient,
        string $staticDir
    ) {
        $this->torrentClient = $torrentClient;
        $this->staticDir = $staticDir;
    }

    /**
     * Add torrent to the system
     *
     * @param AddGeneralTorrentUseCaseArguments $arguments
     * @return AddGeneralTorrentUseCaseResponse
     */
    public function handle(
        AddGeneralTorrentUseCaseArguments $arguments
    ): AddGeneralTorrentUseCaseResponse {
        $filename = $this->staticDir . $arguments->getElementGeneralId() . '.torrent';

        if (!is_file($filename)) {
            return new AddGeneralTorrentUseCaseResponse(false);
        }

        $this->torrentClient->add($filename);

        return new AddGeneralTorrentUseCaseResponse(true);
    }
}
