<?php

namespace BestThor\ScrappingMaster\Tests\Domain\Torrent;

use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralIdMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class TorrentFileMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\Torrent
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TorrentFileMother
{

    /**
     * @param string $sourceDirectory
     *
     * @return TorrentFile
     */
    public static function random(
        string $sourceDirectory = '/tmp'
    ): TorrentFile {
        if (!is_dir($sourceDirectory)) {
            mkdir($sourceDirectory);
        }

        $elementGeneralId = ElementGeneralIdMother::random();

        $filename = $sourceDirectory . '/' .
            $elementGeneralId . '.torrent';

        $content = MotherCreator::random()->text;

        file_put_contents(
            $filename,
            $content
        );

        return new TorrentFile(
            $elementGeneralId,
            $filename
        );
    }
}
