<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesDetailSaveException;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesDetailWriterRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesDetailMother;

/**
 * Class MysqlPdoElementSeriesDetailWriterRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesDetailWriterRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoElementSeriesDetailWriterRepository */
    protected $elementSeriesDetailWriterRepository;

    public function testIfPersistIsValidThenReturnsValidResponse(): void
    {
        $this->elementSeriesDetailWriterRepository = new MysqlPdoElementSeriesDetailWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $result = $this
            ->elementSeriesDetailWriterRepository
            ->persist(
                ElementSeriesDetailMother::random()
            );

        $this->assertTrue($result);
    }

    public function testIfPersistThrowsException(): void
    {
        $this->expectException(ElementSeriesDetailSaveException::class);

        $this->elementSeriesDetailWriterRepository = new MysqlPdoElementSeriesDetailWriterRepository(
            $this->mockPDOThrowException()
        );

        $this
            ->elementSeriesDetailWriterRepository
            ->persist(
                ElementSeriesDetailMother::random()
            );
    }
}
