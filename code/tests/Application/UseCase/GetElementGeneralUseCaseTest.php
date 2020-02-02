<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCase;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Infrastructure\Repository\PDOMockUtilsTestCase;

/**
 * Class GetElementGeneralUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralUseCaseTest extends PDOMockUtilsTestCase
{

    /** @var MysqlPdoElementGeneralReaderRepository */
    protected $elementGeneralReaderRepository;

    /** @var GetElementGeneralUseCase */
    protected $useCase;

    public function testIfGetElementGeneralReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementGeneralCollectionRawMother::random()
            ),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->url
                )
            )
        );

        $this->useCase = new GetElementGeneralUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this
            ->useCase
            ->handle(
                new GetElementGeneralUseCaseArguments(
                    10,
                    1
                )
            );

        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertNotEmpty($response->getElementGeneralCollection());
        $this->assertGreaterThanOrEqual(
            2,
            $response->getElementGeneralCollection()->count()
        );
    }

    public function testIfGetElementGeneralThrowsException(): void
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

        $this->useCase = new GetElementGeneralUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this
            ->useCase
            ->handle(
                new GetElementGeneralUseCaseArguments(
                    10,
                    1
                )
            );

        $this->assertFalse($response->isSuccess());
        $this->assertNotEmpty($response->getError());
        $this->assertIsString($response->getError());
        $this->assertNull($response->getElementGeneralCollection());
    }

    public function testIfGetElementGeneralLimitBelowZero(): void
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

        $this->useCase = new GetElementGeneralUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this
            ->useCase
            ->handle(
                new GetElementGeneralUseCaseArguments(
                    0,
                    1
                )
            );

        $this->assertFalse($response->isSuccess());
        $this->assertNotEmpty($response->getError());
        $this->assertIsString($response->getError());
        $this->assertNull($response->getElementGeneralCollection());
    }

    public function testIfGetElementGeneralPageBelowZero(): void
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

        $this->useCase = new GetElementGeneralUseCase(
            $this->elementGeneralReaderRepository
        );

        $response = $this
            ->useCase
            ->handle(
                new GetElementGeneralUseCaseArguments(
                    10,
                    0
                )
            );

        $this->assertFalse($response->isSuccess());
        $this->assertNotEmpty($response->getError());
        $this->assertIsString($response->getError());
        $this->assertNull($response->getElementGeneralCollection());
    }
}
