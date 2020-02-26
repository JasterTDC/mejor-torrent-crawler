<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class DownloadTorrentUrlMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class DownloadTorrentUrlMother
{

    /**
     * @return string
     */
    public static function random(): string
    {
        return MotherCreator::random()->word . '/' .
            MotherCreator::random()->word . '/' .
            MotherCreator::random()->word . '/';
    }
}
