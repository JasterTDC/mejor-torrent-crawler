<?php

namespace BestThor\ScrappingMaster\Tests\Domain;

use Faker\Factory;
use Faker\Generator;

/**
 * Class MotherCreator
 *
 * @package BestThor\ScrappingMaster\Test\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MotherCreator
{
    /**
     * @var Generator
     */
    private static $faker;

    /**
     * @return Generator
     */
    public static function random(): Generator
    {
        return self::$faker = self::$faker ?: Factory::create();
    }
}
