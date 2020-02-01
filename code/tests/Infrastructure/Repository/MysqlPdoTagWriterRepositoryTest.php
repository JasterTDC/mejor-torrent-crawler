<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\TagSaveException;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoTagWriterRepository;
use BestThor\ScrappingMaster\Tests\Domain\Tag\TagMother;

/**
 * Class MysqlPdoTagWriterRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoTagWriterRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoTagWriterRepository */
    protected $tagWriterRepository;

    protected function tearDown(): void
    {
        $this->tagWriterRepository = null;
    }

    public function testIfTagPersistReturnsValidResponse(): void
    {
        $this->tagWriterRepository = new MysqlPdoTagWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $tag = TagMother::createTagWithoutId();

        $persistedTag = $this
            ->tagWriterRepository
            ->persist($tag);

        $this->assertEquals(
            $tag->getName(),
            $persistedTag->getName()
        );
        $this->assertEquals(
            $tag->getCreatedAt(),
            $persistedTag->getCreatedAt()
        );
        $this->assertEquals(
            $tag->getUpdatedAt(),
            $persistedTag->getUpdatedAt()
        );
        $this->assertGreaterThan(
            1,
            $tag->getId()
        );
    }

    public function testIfTagPersistThrowsException(): void
    {
        $this->expectException(TagSaveException::class);

        $this->tagWriterRepository = new MysqlPdoTagWriterRepository(
            $this->mockPDOThrowException()
        );

        $tag = TagMother::createTagWithoutId();

        $this
            ->tagWriterRepository
            ->persist($tag);
    }
}
