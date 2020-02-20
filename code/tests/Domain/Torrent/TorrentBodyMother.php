<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Torrent;

/**
 * Class TorrentBodyMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TorrentBodyMother
{
    private const SUCCESS = 'success';

    /**
     * @return string
     */
    public static function random(): string
    {
        return json_encode([
            self::SUCCESS => true
        ]);
    }
}
