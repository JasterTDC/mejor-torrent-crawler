<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * AddSeriesTorrentUseCase
 *
 * @author Ismael Moral <jastertdc@gmail.com>
 */
final class AddSeriesTorrentUseCase
{
    /**
     * Static series torrent directory
     *
     * @var string
     */
    protected $staticSeriesTorrentDir;

    /**
     * Torrent client
     *
     * @var TorrentClientInterface
     */
    protected $torrentClient;

    /**
     * AddSeriesTorrentUseCase
     *
     * @param string $staticSeriesTorrentDir
     * @param TorrentClientInterface $torrentClient
     */
    public function __construct(
        string $staticSeriesTorrentDir,
        TorrentClientInterface $torrentClient
    ) {
        $this->staticSeriesTorrentDir = $staticSeriesTorrentDir;
        $this->torrentClient = $torrentClient;
    }
    
    /**
     * AddSeriesTorrentUseCase constructor
     *
     * @param AddSeriesTorrentUseCaseArguments $arguments
     * @return AddSeriesTorrentUseCaseResponse
     */
    public function handle(
        AddSeriesTorrentUseCaseArguments $arguments
    ): AddSeriesTorrentUseCaseResponse {
        $torrentDir = $this->staticSeriesTorrentDir .
            $arguments->getSeriesName();

        if (!is_dir($torrentDir)) {
            return new AddSeriesTorrentUseCaseResponse(
                false,
                'The selected series directory does not exist'
            );
        }

        /** @var \DirectoryIterator $file */
        foreach (new \DirectoryIterator($torrentDir) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $this->torrentClient->add($file->getPathname());
        }

        return new AddSeriesTorrentUseCaseResponse(
            true,
            null
        );
    }
}
