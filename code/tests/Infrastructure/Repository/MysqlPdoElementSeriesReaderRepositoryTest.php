<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\Series\ElementSeriesEmptyException;
use BestThor\ScrappingMaster\Domain\Series\TotalElementSeriesException;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesTotalRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;

/**
 * Class MysqlPdoElementSeriesReaderRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementSeriesReaderRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoElementSeriesReaderRepository */
    protected $elementSeriesReaderRepository;

    public function testIfGetByPageAndLimitReturnsValidResponse(): void
    {
        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementSeriesCollectionRawMother::random()
            )
        );

        $elementSeriesCollection = $this
            ->elementSeriesReaderRepository
            ->getElementSeriesByPageAndLimit(
                MotherCreator::random()->numberBetween(1, 500),
                MotherCreator::random()->numberBetween(100, 500)
            );

        $this->assertGreaterThanOrEqual(
            2,
            $elementSeriesCollection->count()
        );
    }

    public function testIfGetByPageAndLimitThrowsException(): void
    {
        $this->expectException(ElementSeriesEmptyException::class);

        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOThrowException()
        );

        $this
            ->elementSeriesReaderRepository
            ->getElementSeriesByPageAndLimit(
                MotherCreator::random()->numberBetween(1, 500),
                MotherCreator::random()->numberBetween(100, 500)
            );
    }

    public function testIfGetByPageAndLimitReturnsEmpty(): void
    {
        $this->expectException(ElementSeriesEmptyException::class);

        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndReturnsEmpty()
        );

        $this
            ->elementSeriesReaderRepository
            ->getElementSeriesByPageAndLimit(
                MotherCreator::random()->numberBetween(1, 500),
                MotherCreator::random()->numberBetween(100, 500)
            );
    }

    public function testIfGetTotalReturnsValidResponse(): void
    {
        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementSeriesTotalRawMother::random()
            )
        );

        $total = $this
            ->elementSeriesReaderRepository
            ->getTotal();

        $this->assertIsInt($total);
        $this->assertNotEmpty($total);
        $this->assertGreaterThanOrEqual(2, $total);
    }

    public function testIfGetTotalThrowsException(): void
    {
        $this->expectException(TotalElementSeriesException::class);

        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOThrowException()
        );

        $this
            ->elementSeriesReaderRepository
            ->getTotal();
    }

    public function testIfGetTotalFetchEmpty(): void
    {
        $this->expectException(TotalElementSeriesException::class);

        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndFetchEmpty()
        );

        $this
            ->elementSeriesReaderRepository
            ->getTotal();
    }

    public function testIfGetTotalReturnsEmpty(): void
    {
        $this->expectException(TotalElementSeriesException::class);

        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndReturnsEmpty()
        );

        $this
            ->elementSeriesReaderRepository
            ->getTotal();
    }
}
