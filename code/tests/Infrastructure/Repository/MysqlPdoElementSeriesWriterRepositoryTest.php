<?php


namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesSaveException;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesWriterRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesMother;

/**
 * Class MysqlPdoElementSeriesWriterRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesWriterRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoElementSeriesWriterRepository */
    protected $elementSeriesWriterRepository;

    protected function tearDown(): void
    {
        $this->elementSeriesWriterRepository = null;
    }

    public function testIfElementSeriesWithoutEpisodesPersistReturnsValidResponse(): void
    {
        $this->elementSeriesWriterRepository = new MysqlPdoElementSeriesWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $elementSeries = ElementSeriesMother::createWithoutEpisodes();

        $result = $this
            ->elementSeriesWriterRepository
            ->persist($elementSeries);

        $this->assertTrue($result);
    }

    public function testIfElementSeriesReturnsValidResponse(): void
    {
        $this->elementSeriesWriterRepository = new MysqlPdoElementSeriesWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $elementSeries = ElementSeriesMother::create();

        $result = $this
            ->elementSeriesWriterRepository
            ->persist($elementSeries);

        $this->assertTrue($result);
    }

    public function testIfElementSeriesThrowsException(): void
    {
        $this->expectException(ElementSeriesSaveException::class);

        $this->elementSeriesWriterRepository = new MysqlPdoElementSeriesWriterRepository(
            $this->mockPDOThrowException()
        );

        $elementSeries = ElementSeriesMother::create();

        $result = $this
            ->elementSeriesWriterRepository
            ->persist($elementSeries);

        $this->assertFalse($result);
    }
}
