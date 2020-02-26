<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

/**
 * Class ElementGeneralLinkRawMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ElementGeneralLinkRawMother
{
    protected const BASE_URL = '/peli-descargar-torrent-%s-%s.html';

    /**
     * @return string
     */
    public static function random(): string
    {
        $url = sprintf(
            self::BASE_URL,
            ElementGeneralIdMother::random(),
            ElementGeneralSlugMother::random()
        );

        return "<a href='{$url}'></a>";
    }
}
