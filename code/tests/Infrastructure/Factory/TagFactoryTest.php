<?php


namespace BestThor\ScrappingMaster\Tests\Infrastructure\Factory;

use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use BestThor\ScrappingMaster\Tests\Domain\TagCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\TagRawMother;
use PHPUnit\Framework\TestCase;

/**
 * Class TagFactoryTest
 *
 * @package BestThor\ScrappingMaster\Test\Infrastructure\Factory
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TagFactoryTest extends TestCase
{

    // Date format
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var TagFactory
     */
    protected $tagFactory;

    protected function setUp(): void
    {
        $this->tagFactory = new TagFactory();
    }

    protected function tearDown(): void
    {
        $this->tagFactory = null;
    }

    public function testIfRawTagIsFullThenTagIsCreatedSuccessfully()
    {
        $rawTag = TagRawMother::random();

        $tag = $this
            ->tagFactory
            ->createTagFromRaw($rawTag);

        $this->assertEquals($tag->getId(), $rawTag['id']);
        $this->assertEquals($tag->getName(), $rawTag['name']);
        $this->assertEquals(
            $tag->getCreatedAt()->format(self::DATE_FORMAT),
            $rawTag['createdAt']
        );
        $this->assertEquals(
            $tag->getUpdatedAt()->format(self::DATE_FORMAT),
            $rawTag['updatedAt']
        );
    }

    public function testIfRawTagHasOnlyNameThenTagIsCreatedSuccessfully()
    {
        $rawTag = TagRawMother::createWithOnlyName();

        $tag = $this
            ->tagFactory
            ->createTagFromRaw($rawTag);

        $current = new \DateTimeImmutable();
        $current->setTime(0, 0, 0);

        $this->assertEquals($tag->getName(), $rawTag['name']);
        $this->assertArrayNotHasKey('id', $rawTag);
        $this->assertArrayNotHasKey('createdAt', $rawTag);
        $this->assertArrayNotHasKey('updatedAt', $rawTag);
        $this->assertNull($tag->getId());
        $this->assertGreaterThanOrEqual($tag->getCreatedAt(), $current);
        $this->assertGreaterThanOrEqual($tag->getUpdatedAt(), $current);
    }

    public function testIfRawTagDoesNotHaveIdThenTagIsCreatedSuccessfully()
    {
        $rawTag = TagRawMother::createWithoutId();

        $tag = $this
            ->tagFactory
            ->createTagFromRaw($rawTag);

        $this->assertNull($tag->getId());
        $this->assertArrayNotHasKey('id', $rawTag);
        $this->assertEquals($tag->getName(), $rawTag['name']);
        $this->assertEquals(
            $tag->getCreatedAt()->format(self::DATE_FORMAT),
            $rawTag['createdAt']
        );
        $this->assertEquals(
            $tag->getUpdatedAt()->format(self::DATE_FORMAT),
            $rawTag['updatedAt']
        );
    }

    public function testIfRawTagCollectionHasOneThenTagCollectionIsCreatedSuccessfully()
    {
        $rawTagCollection = TagCollectionRawMother::createWithOne();

        $tagCollection = $this
            ->tagFactory
            ->createTagCollectionFromRaw(
                $rawTagCollection
            );

        $this->assertEquals(1, $tagCollection->count());
    }

    public function testIfRawTagCollectionIsValidThenTagCollectionIsCreatedSuccessfully()
    {
        $rawTagCollection = TagCollectionRawMother::create();

        $tagCollection = $this
            ->tagFactory
            ->createTagCollectionFromRaw(
                $rawTagCollection
            );

        $this->assertGreaterThanOrEqual(2, $tagCollection->count());
    }

    public function testIfRawTagCollectionIsEmptyThenTagCollectionIsCreatedSuccessfully()
    {
        $rawTagCollection = TagCollectionRawMother::createEmpty();

        $tagCollection = $this
            ->tagFactory
            ->createTagCollectionFromRaw(
                $rawTagCollection
            );

        $this->assertGreaterThanOrEqual(0, $tagCollection->count());
    }
}
