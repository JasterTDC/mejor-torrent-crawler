<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory\Tag;

use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\GeneralTagFactory;
use BestThor\ScrappingMaster\Tests\Domain\Tag\GeneralTagRawMother;
use PHPUnit\Framework\TestCase;

/**
 * Class GeneralTagFactoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GeneralTagFactoryTest extends TestCase
{

    // Date format
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var GeneralTagFactory */
    protected $generalTagFactory;

    protected function setUp(): void
    {
        $this->generalTagFactory = new GeneralTagFactory();
    }

    protected function tearDown(): void
    {
        $this->generalTagFactory = null;
    }

    public function testIfGeneralTagHasAllParametersThenObjectIsCreated()
    {
        $rawGeneralTag = GeneralTagRawMother::random();

        $generalTag = $this
            ->generalTagFactory
            ->createFromRaw(
                $rawGeneralTag
            );

        $this->assertEquals(
            $rawGeneralTag['generalId'],
            $generalTag->getGeneralId()
        );
        $this->assertEquals(
            $rawGeneralTag['tagId'],
            $generalTag->getTagId()
        );
        $this->assertEquals(
            $rawGeneralTag['createdAt'],
            $generalTag->getCreatedAt()->format(self::DATE_FORMAT)
        );
        $this->assertEquals(
            $rawGeneralTag['updatedAt'],
            $generalTag->getUpdatedAt()->format(self::DATE_FORMAT)
        );
    }

    public function testIfGeneralTagHasRequiredParametersThenObjectIsCreated()
    {
        $rawGeneralTag = GeneralTagRawMother::createWithRequiredOnly();

        $current = new \DateTimeImmutable();
        $current = $current->setTime(0, 0, 0);

        $generalTag = $this
            ->generalTagFactory
            ->createFromRaw(
                $rawGeneralTag
            );

        $this->assertEquals(
            $rawGeneralTag['generalId'],
            $generalTag->getGeneralId()
        );
        $this->assertEquals(
            $rawGeneralTag['tagId'],
            $generalTag->getTagId()
        );
        $this->assertGreaterThanOrEqual(
            $current,
            $generalTag->getCreatedAt()
        );
        $this->assertGreaterThanOrEqual(
            $current,
            $generalTag->getUpdatedAt()
        );
        $this->assertArrayNotHasKey('createdAt', $rawGeneralTag);
        $this->assertArrayNotHasKey('updatedAt', $rawGeneralTag);
    }
}
