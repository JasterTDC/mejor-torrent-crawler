<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Domain\ElementDownload;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementGeneralDownloadMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDownloadMother
{

    /**
     * @return ElementDownload
     */
    public static function random(): ElementDownload
    {
        return new ElementDownload(
            MotherCreator::random()->url,
            MotherCreator::random()->lastname . '.torrent'
        );
    }
}
