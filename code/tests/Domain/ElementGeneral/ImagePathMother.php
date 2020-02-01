<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class ImagePathMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class ImagePathMother
{
    public const IMAGE_PATH = '/uploads/imagenes/peliculas/';

    /**
     * @return string
     */
    public static function random(): string
    {
        return self::IMAGE_PATH . MotherCreator::random()->lastName . '.jpg';
    }
}
