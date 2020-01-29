<?php


namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class DownloadNameMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class DownloadMother
{

    const DOWNLOAD_PATH = '/uploads/torrents/peliculas/';

    /**
     * @return array
     */
    public static function random() : array
    {
        return [
            'downloadName' => MotherCreator::random()->lastName .
                '.torrent'
        ];
    }
}
