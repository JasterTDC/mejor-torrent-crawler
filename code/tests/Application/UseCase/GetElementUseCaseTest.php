<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCase;
use BestThor\ScrappingMaster\Application\UseCase\GetElementUseCaseArguments;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesDescriptionFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\Series\FromMysqlElementSeriesImageFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\General\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\Series\MysqlPdoElementSeriesReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementSeries\ElementSeriesCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Infrastructure\Repository\PDOMockUtilsTestCase;

/**
 * Class GetElementUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementUseCaseTest extends PDOMockUtilsTestCase
{

    /** @var MysqlPdoElementGeneralReaderRepository */
    protected $elementGeneralReaderRepository;

    /** @var MysqlPdoElementSeriesReaderRepository */
    protected $elementSeriesReaderRepository;

    /** @var GetElementUseCase */
    protected $useCase;

    public function testIfBothCollectionsAreNotEmptyThenReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementGeneralCollectionRawMother::random()
            ),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );
        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementSeriesCollectionRawMother::random()
            )
        );
        $this->useCase = new GetElementUseCase(
            $this->elementGeneralReaderRepository,
            $this->elementSeriesReaderRepository
        );

        $response = $this->useCase->handle(
            new GetElementUseCaseArguments(
                MotherCreator::random()->numberBetween(1, 500),
                MotherCreator::random()->numberBetween(100, 200)
            )
        );

        $this->assertTrue($response->isSuccess());
        $this->assertGreaterThanOrEqual(
            2,
            $response->getElementGeneralCollection()->count()
        );
        $this->assertNotEmpty($response->getElementGeneralCollection());
        $this->assertNotEmpty($response->getElementSeriesCollection());
        $this->assertGreaterThanOrEqual(
            2,
            $response->getElementSeriesCollection()->count()
        );
        $this->assertNull($response->getError());
    }

    public function testIfGeneralCollectionIsEmptyThenReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOThrowException(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );
        $this->elementSeriesReaderRepository = new MysqlPdoElementSeriesReaderRepository(
            new FromMysqlElementSeriesFactory(
                new FromMysqlElementSeriesImageFactory(),
                new FromMysqlElementSeriesDescriptionFactory()
            ),
            $this->mockPDOThrowException()
        );
        $this->useCase = new GetElementUseCase(
            $this->elementGeneralReaderRepository,
            $this->elementSeriesReaderRepository
        );

        $response = $this->useCase->handle(
            new GetElementUseCaseArguments(
                MotherCreator::random()->numberBetween(1, 500),
                MotherCreator::random()->numberBetween(100, 200)
            )
        );

        $this->assertFalse($response->isSuccess());
        $this->assertIsString($response->getError());
        $this->assertNotEmpty($response->getError());
        $this->assertNull($response->getElementGeneralCollection());
        $this->assertNull($response->getElementSeriesCollection());
    }
}
