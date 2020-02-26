<?php

namespace BestThor\ScrappingMaster\Tests\Application\UseCase;

use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailRequest;
use BestThor\ScrappingMaster\Application\UseCase\ElementGeneral\GetElementGeneralDetailUseCase;
use BestThor\ScrappingMaster\Domain\General\ElementGeneral;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\General\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\General\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralIdMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralRawMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use Mockery;

/**
 * Class GetElementGeneralDetailUseCaseTest
 *
 * @package BestThor\ScrappingMaster\Tests\Application\UseCase
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralDetailUseCaseTest extends TestCase
{
    /** @var MysqlPdoElementGeneralReaderRepository  */
    protected MysqlPdoElementGeneralReaderRepository $readerRepository;

    /** @var GetElementGeneralDetailUseCase  */
    protected GetElementGeneralDetailUseCase $useCase;

    public function testIfIdIsValidThenReturnsValidResponse(): void
    {
        $mockPdoStatement = Mockery::mock(PDOStatement::class);
        $mockPdoStatement->shouldReceive([
            'execute'   => true,
            'fetch'     => ElementGeneralRawMother::random()
        ]);
        $mockPdo = Mockery::mock(PDO::class);
        $mockPdo->shouldReceive([
            'prepare' => $mockPdoStatement
        ]);
        $mockPdoAccess = Mockery::mock(PdoAccess::class);
        $mockPdoAccess->shouldReceive([
            'getPdo' => $mockPdo
        ]);

        $this->readerRepository = new MysqlPdoElementGeneralReaderRepository(
            $mockPdoAccess,
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->url
                )
            )
        );

        $this->useCase = new GetElementGeneralDetailUseCase(
            $this->readerRepository
        );
        $response = $this
            ->useCase
            ->handle(
                new GetElementGeneralDetailRequest(
                    ElementGeneralIdMother::random()
                )
            );

        $this->assertTrue($response->isSuccess());
        $this->assertNull($response->getError());
        $this->assertInstanceOf(
            ElementGeneral::class,
            $response->getElementGeneral()
        );
        $this->assertIsInt($response->getElementGeneral()->getElementId());
    }
}
