<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

/**
 * Class ElementGeneralDownloadHtmlMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDownloadHtmlMother
{

    /**
     * @return string
     */
    public static function random(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-download.html'
        );
    }

    /**
     * @return string
     */
    public static function createWithoutName(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-download-without-name.html'
        );
    }
}
