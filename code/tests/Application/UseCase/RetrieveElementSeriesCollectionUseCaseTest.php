<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementSeries\RetrieveElementSeriesCollectionUseCaseArguments;
use BestThor\ScrappingMaster\Domain\Series\ElementSeriesCollection;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesTotalRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use Mockery;
use PDO;
use PDOStatement;
use PDOException;
use PHPUnit\Framework\TestCase;

/**
 * Class RetrieveElementSeriesCollectionUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementSeriesCollectionUseCaseTest extends TestCase
{

    /** @var MysqlPdoElementSeriesReaderRepository */
    protected MysqlPdoElementSeriesReaderRepository $readerRepository;

    /** @var RetrieveElementSeriesCollectionUseCase  */
    protected RetrieveElementSeriesCollectionUseCase $useCase;

    public function testIfParametersAreValidThenReturnsValidResponse(): void
    {
        $mockPdoStatement = Mockery::mock(PDOStatement::class);
        $mockPdoStatement
            ->shouldReceive('fetchAll')
            ->times(2)
            ->andReturn(
                ElementSeriesCollectionRawMother::random(),
                ElementSeriesTotalRawMother::create(
                    MotherCreator::random()->numberBetween(100, 150)
                )
            );
        $mockPdoStatement
            ->shouldReceive('execute')
            ->times(2)
            ->andReturnTrue();
        $mockPdo = Mockery::mock(PDO::class);
        $mockPdo
            ->shouldReceive('prepare')
            ->andReturn($mockPdoStatement);
        $mockPdoAccess = Mockery::mock(PdoAccess::class);
        $mockPdoAccess
            ->shouldReceive('getPdo')
            ->andReturn($mockPdo);

        $this->readerRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $mockPdoAccess
        );
        $this->useCase = new RetrieveElementSeriesCollectionUseCase(
            $this->readerRepository
        );
        $response = $this->useCase->handle(
            new RetrieveElementSeriesCollectionUseCaseArguments(
                1,
                MotherCreator::random()->numberBetween(5, 10)
            )
        );

        $this->assertTrue($response->getSuccess());
        $this->assertNull($response->getError());
        $this->assertIsInt($response->getNextPage());
        $this->assertNull($response->getPreviousPage());
        $this->assertInstanceOf(
            ElementSeriesCollection::class,
            $response->getElementSeriesCollection()
        );
    }

    public function testIfPageIsAboveOneThenReturnsValidResponse(): void
    {
        $mockPdoStatement = Mockery::mock(PDOStatement::class);
        $mockPdoStatement
            ->shouldReceive('fetchAll')
            ->times(2)
            ->andReturn(
                ElementSeriesCollectionRawMother::random(),
                ElementSeriesTotalRawMother::create(
                    MotherCreator::random()->numberBetween(100, 150)
                )
            );
        $mockPdoStatement
            ->shouldReceive('execute')
            ->times(2)
            ->andReturnTrue();
        $mockPdo = Mockery::mock(PDO::class);
        $mockPdo
            ->shouldReceive('prepare')
            ->andReturn($mockPdoStatement);
        $mockPdoAccess = Mockery::mock(PdoAccess::class);
        $mockPdoAccess
            ->shouldReceive('getPdo')
            ->andReturn($mockPdo);

        $this->readerRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $mockPdoAccess
        );
        $this->useCase = new RetrieveElementSeriesCollectionUseCase(
            $this->readerRepository
        );
        $response = $this->useCase->handle(
            new RetrieveElementSeriesCollectionUseCaseArguments(
                2,
                MotherCreator::random()->numberBetween(5, 10)
            )
        );

        $this->assertTrue($response->getSuccess());
        $this->assertNull($response->getError());
        $this->assertIsInt($response->getNextPage());
        $this->assertIsInt($response->getPreviousPage());
        $this->assertInstanceOf(
            ElementSeriesCollection::class,
            $response->getElementSeriesCollection()
        );
    }

    public function testIfRepositoryThrowsExceptionThenReturnsValidResponse(): void
    {
        $mockPdoStatement = Mockery::mock(PDOStatement::class);
        $mockPdoStatement
            ->shouldReceive('execute')
            ->andThrow(new PDOException());
        $mockPdo = Mockery::mock(PDO::class);
        $mockPdo
            ->shouldReceive('prepare')
            ->andReturn($mockPdoStatement);
        $mockPdoAccess = Mockery::mock(PdoAccess::class);
        $mockPdoAccess
            ->shouldReceive('getPdo')
            ->andReturn($mockPdo);

        $this->readerRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $mockPdoAccess
        );
        $this->useCase = new RetrieveElementSeriesCollectionUseCase(
            $this->readerRepository
        );
        $response = $this->useCase->handle(
            new RetrieveElementSeriesCollectionUseCaseArguments(
                2,
                MotherCreator::random()->numberBetween(5, 10)
            )
        );

        $this->assertFalse($response->getSuccess());
        $this->assertIsString($response->getError());
        $this->assertNull($response->getNextPage());
        $this->assertNull($response->getPreviousPage());
        $this->assertNull(
            $response->getElementSeriesCollection()
        );
    }
}
