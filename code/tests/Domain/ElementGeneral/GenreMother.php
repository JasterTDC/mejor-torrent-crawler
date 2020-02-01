<?php

namespace BestThor\ScrappingMaster\Tests\Domain\ElementGeneral;

use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class GenreMother
 *
 * @package BestThor\ScrappingMaster\Tests\Domain\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GenreMother
{

    /**
     * @return string
     */
    public static function random(): string
    {
        $totalGenres = MotherCreator::random()->numberBetween(1, 5);

        if ($totalGenres === 1) {
            return MotherCreator::random()->domainName;
        }

        $genreArr = [];

        for ($i = 0; $i < $totalGenres; $i++) {
            $genreArr[] = MotherCreator::random()->domainName;
        }

        return implode('-', $genreArr);
    }
}
