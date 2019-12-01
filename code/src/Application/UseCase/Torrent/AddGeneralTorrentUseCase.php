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

    public function handle(
        AddGeneralTorrentUseCaseArguments $arguments
    ) : AddGeneralTorrentUseCaseResponse {
        $filename = $this->staticDir . $arguments->getElementGeneralId() . '.torrent';

        if (!is_file($filename)) {
            return new AddGeneralTorrentUseCaseResponse(false);
        }

        $response = $this->torrentClient->add($filename);

        var_dump($response);die();

        return new AddGeneralTorrentUseCaseResponse(true);
    }
}
