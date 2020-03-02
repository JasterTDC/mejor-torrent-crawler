<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\TagCriteria;
use BestThor\ScrappingMaster\Domain\Tag\TagSearchException;
use BestThor\ScrappingMaster\Infrastructure\Factory\Tag\TagFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Infrastructure\Repository\Tag\MysqlPdoTagReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Domain\Tag\TagRawMother;
use Mockery;
use PDO;
use PDOStatement;

/**
 * Class MysqlPdoTagReaderRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoTagReaderRepositoryTest extends PDOMockUtilsTestCase
{

    /** @var MysqlPdoTagReaderRepository */
    protected $tagReaderRepository;

    public function testIfFindByNameReturnsValidResponse(): void
    {
        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                TagRawMother::random()
            ),
            new TagFactory()
        );

        $tag = $this
            ->tagReaderRepository
            ->findByName(
                MotherCreator::random()->lastName
            );

        $this->assertIsInt($tag->getId());
        $this->assertGreaterThanOrEqual(1, $tag->getId());
        $this->assertNotEmpty($tag->getId());
        $this->assertIsString($tag->getName());
        $this->assertNotEmpty($tag->getName());
        $this->assertNotEmpty($tag->getCreatedAt());
        $this->assertNotEmpty($tag->getUpdatedAt());
    }

    public function testIfFindByNameThrowsException(): void
    {
        $this->expectException(TagSearchException::class);

        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $this->mockPDOThrowException(),
            new TagFactory()
        );

        $this
            ->tagReaderRepository
            ->findByName(
                MotherCreator::random()->lastName
            );
    }

    public function testIfFindByNameReturnsEmpty(): void
    {
        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $this->mockPDOExecuteOnceASelectAndFetchEmpty(),
            new TagFactory()
        );

        $result = $this
            ->tagReaderRepository
            ->findByName(
                MotherCreator::random()->lastName
            );

        $this->assertNull($result);
    }

    public function testIfFindAllReturnsEmptyStatement(): void
    {
        $mockPdoStatement = Mockery::mock(PDOStatement::class);
        $mockPdoStatement
            ->shouldReceive('fetchAll')
            ->andReturn(null);

        $mockPdoStatement
            ->shouldReceive('execute')
            ->andReturn(true);

        $mockPdo = Mockery::mock(PDO::class);
        $mockPdo
            ->shouldReceive('prepare')
            ->andReturn($mockPdoStatement);

        $mockPdoAccess = Mockery::mock(PdoAccess::class);
        $mockPdoAccess
            ->shouldReceive('getPdo')
            ->andReturn($mockPdo);

        $this->tagReaderRepository = new MysqlPdoTagReaderRepository(
            $mockPdoAccess,
            new TagFactory()
        );

        $tagCriteria = new TagCriteria();
        $tagCriteria->setOderType(
            TagCriteria::ORDER_TYPE_ASC
        );
        $tagCriteria->setOrderBy(
            TagCriteria::ORDER_NAME
        );

        $result = $this
            ->tagReaderRepository
            ->findAll($tagCriteria);

        $this->assertNull($result);
    }
}
