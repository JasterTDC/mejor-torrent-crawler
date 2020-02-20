<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\RetrieveElementGeneralCollectionUseCaseArguments;
use BestThor\ScrappingMaster\Domain\ElementGeneralReaderRepositoryInterface;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Infrastructure\Repository\PDOMockUtilsTestCase;

/**
 * Class RetrieveElementGeneralCollectionUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class RetrieveElementGeneralCollectionUseCaseTest extends PDOMockUtilsTestCase
{

    /** @var MysqlPdoElementGeneralReaderRepository */
    protected $elementGeneralReaderRepository;

    /** @var RetrieveElementGeneralCollectionUseCase */
    protected $useCase;

    public function testIfRetrieveElementGeneralReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementGeneralCollectionRawMother::random(),
                false
            ),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->url
                )
            )
        );

        $this->useCase = new RetrieveElementGeneralCollectionUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this->useCase->handle(
            new RetrieveElementGeneralCollectionUseCaseArguments(
                1,
                10
            )
        );

        $this->assertTrue($response->getSuccess());
        $this->assertNull($response->getError());
        $this->assertNotEmpty($response->getElementGeneralCollection());
    }

    public function testIfRetrieveElementGeneralThrowsException(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOThrowException(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->url
                )
            )
        );

        $this->useCase = new RetrieveElementGeneralCollectionUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this->useCase->handle(
            new RetrieveElementGeneralCollectionUseCaseArguments(
                MotherCreator::random()->numberBetween(1, 20),
                MotherCreator::random()->numberBetween(100, 500)
            )
        );

        $this->assertFalse($response->getSuccess());
        $this->assertIsString($response->getError());
        $this->assertNotEmpty($response->getError());
        $this->assertNull($response->getPreviousPage());
        $this->assertNull($response->getNextPage());
    }

    public function testIfPageIsBelowTotalThenReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = $this->createMock(
            ElementGeneralReaderRepositoryInterface::class
        );
        $this
            ->elementGeneralReaderRepository
            ->method('getElementGeneralByPage')
            ->willReturn(
                ElementGeneralCollectionMother::random()
            );
        $this
            ->elementGeneralReaderRepository
            ->method('getTotal')
            ->willReturn(MotherCreator::random()->numberBetween(200, 500));

        $this->useCase = new RetrieveElementGeneralCollectionUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this
            ->useCase
            ->handle(
                new RetrieveElementGeneralCollectionUseCaseArguments(
                    MotherCreator::random()->numberBetween(2, 15),
                    MotherCreator::random()->numberBetween(1, 10)
                )
            );

        $this->assertTrue($response->getSuccess());
        $this->assertGreaterThanOrEqual(15, $response->getTotal());
        $this->assertGreaterThanOrEqual(
            1,
            $response->getElementGeneralCollection()->count()
        );
        $this->assertNull($response->getError());
        $this->assertIsInt($response->getNextPage());
        $this->assertIsInt($response->getPreviousPage());
    }
}
