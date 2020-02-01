<?php


namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\ElementGeneralCollectionEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Domain\ElementGeneralTotalException;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDetailFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementDownloadFactory;
use BestThor\ScrappingMaster\Infrastructure\Factory\ElementGeneralFactory;
use BestThor\ScrappingMaster\Infrastructure\Repository\MysqlPdoElementGeneralReaderRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralCollectionRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralRawMother;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\GeneralTotalMother;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use BestThor\ScrappingMaster\Tests\Domain\Tag\GeneralIdMother;

/**
 * Class MysqlPdoElementGeneralReaderRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralReaderRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoElementGeneralReaderRepository */
    protected $elementGeneralReaderRepository;

    public function testGetElementGeneralByIdExistsThenReturnsValidResponse(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                ElementGeneralRawMother::random()
            ),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $generalId = GeneralIdMother::random();

        $elementGeneral = $this
            ->elementGeneralReaderRepository
            ->getById($generalId);

        $this->assertIsInt($elementGeneral->getElementId());
        $this->assertIsString($elementGeneral->getElementName());
        $this->assertIsString($elementGeneral->getElementSlug());
        $this->assertIsString($elementGeneral->getElementLink());
        $this->assertNotEmpty($elementGeneral->getElementName());
        $this->assertNotEmpty($elementGeneral->getElementSlug());
        $this->assertNotEmpty($elementGeneral->getElementLink());
    }

    public function testIfGetByIdReturnsEmpty(): void
    {
        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnsEmpty(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $result = $this
            ->elementGeneralReaderRepository
            ->getById(
                GeneralIdMother::random()
            );

        $this->assertNull($result);
    }

    public function testIfGetByIdThrowsException(): void
    {
        $this->expectException(ElementGeneralEmptyException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOThrowException(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getById(
                GeneralIdMother::random()
            );
    }

    public function testIfGetTotalReturnsValidResponse(): void
    {
        $totalRaw = GeneralTotalMother::random();

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnRows(
                $totalRaw
            ),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $total = $this
            ->elementGeneralReaderRepository
            ->getTotal();

        $this->assertEquals($totalRaw[0]['total'], $total);
    }

    public function testIfGetTotalReturnsEmpty(): void
    {
        $this->expectException(ElementGeneralTotalException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnsEmpty(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getTotal();
    }

    public function testIfGetTotalThrowsException(): void
    {
        $this->expectException(ElementGeneralTotalException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOThrowException(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getTotal();
    }

    public function testIfGetByPageAndLimitReturnsValidResponse(): void
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

        $elementGeneralCollection = $this
            ->elementGeneralReaderRepository
            ->getElementGeneralByPage(
                1,
                10
            );

        $this->assertGreaterThanOrEqual(
            2,
            $elementGeneralCollection->count()
        );
    }

    public function testIfGetByPageAndLimitThrowsException(): void
    {
        $this->expectException(ElementGeneralCollectionEmptyException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOThrowException(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getElementGeneralByPage(
                1,
                10
            );
    }

    public function testIfGetByPageAndLimitReturnsEmpty(): void
    {
        $this->expectException(ElementGeneralCollectionEmptyException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndReturnsEmpty(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getElementGeneralByPage(
                1,
                10
            );
    }

    public function testIfGetByPageAndLimitFetchEmpty(): void
    {
        $this->expectException(ElementGeneralCollectionEmptyException::class);

        $this->elementGeneralReaderRepository = new MysqlPdoElementGeneralReaderRepository(
            $this->mockPDOExecuteOnceASelectAndFetchEmpty(),
            new ElementGeneralFactory(
                new ElementDetailFactory(),
                new ElementDownloadFactory(
                    MotherCreator::random()->slug
                )
            )
        );

        $this
            ->elementGeneralReaderRepository
            ->getElementGeneralByPage(
                1,
                10
            );
    }
}

