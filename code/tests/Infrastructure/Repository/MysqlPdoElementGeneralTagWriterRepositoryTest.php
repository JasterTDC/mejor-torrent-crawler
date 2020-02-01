<?php


namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Tag\GeneralTagSaveException;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralTagWriterRepository;
use BestThor\ScrappingMaster\Tests\Domain\Tag\GeneralTagMother;

/**
 * Class MysqlPdoElementGeneralTagWriterRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralTagWriterRepositoryTest extends PDOMockUtilsTestCase
{

    /** @var MysqlPdoElementGeneralTagWriterRepository */
    protected $elementGeneralTagWriterRepository;

    public function testIfGeneralTagPersistReturnsValidResponse(): void
    {
        $this->elementGeneralTagWriterRepository = new MysqlPdoElementGeneralTagWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $generalTag = GeneralTagMother::random();

        $result = $this
            ->elementGeneralTagWriterRepository
            ->persist($generalTag);

        $this->assertTrue($result);
    }

    public function testIfGeneralTagPersistThrowsException(): void
    {
        $this->expectException(GeneralTagSaveException::class);

        $this->elementGeneralTagWriterRepository = new MysqlPdoElementGeneralTagWriterRepository(
            $this->mockPDOThrowException()
        );

        $generalTag = GeneralTagMother::random();

        $this
            ->elementGeneralTagWriterRepository
            ->persist($generalTag);
    }
}
