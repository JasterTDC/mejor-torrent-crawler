<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

/**
 * Class ElementGeneralDetailRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralDetailRawMother
{

    /**
     * @return string
     */
    public static function random(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-detail.html'
        );
    }

    /**
     * @return string
     */
    public static function createWithoutGenre(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-detail-without-genre.html'
        );
    }

    /**
     * @return string
     */
    public static function createWithoutFormat(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-detail-without-format.html'
        );
    }

    /**
     * @return string
     */
    public static function createWithoutDate(): string
    {
        return file_get_contents(
            __DIR__ . '/../../general-detail-without-date.html'
        );
    }
}
