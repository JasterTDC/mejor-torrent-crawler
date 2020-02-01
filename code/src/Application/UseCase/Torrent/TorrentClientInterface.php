<?php

namespace BestThor\ScrappingMaster\Application\UseCase\Torrent;

/**
 * Interface TorrentClientInterface
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
interface TorrentClientInterface
{

    /**
     * @param string $filename
     *
     * @return array
     */
    public function add(string $filename): array;
}
