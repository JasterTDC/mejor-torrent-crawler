<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementSeries;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDownload;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ElementSeriesDownloadMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementSeries
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementSeriesDownloadMother
{
    /**
     * @return ElementSeriesDownload
     */
    public static function random(): ElementSeriesDownload
    {
        return new ElementSeriesDownload(
            MotherCreator::random()->firstName . '.torrent',
            MotherCreator::random()->url
        );
    }
}
