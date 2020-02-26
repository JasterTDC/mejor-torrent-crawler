<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Domain\General\ElementGeneralPersistException;
use BestThor\ScrappingMaster\Infrastructure\Repository\General\MysqlPdoElementGeneralWriterRepository;
use BestThor\ScrappingMaster\Tests\Domain\ElementGeneral\ElementGeneralMother;

/**
 * Class MysqlPdoElementGeneralWriterRepositoryTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class MysqlPdoElementGeneralWriterRepositoryTest extends PDOMockUtilsTestCase
{
    /** @var MysqlPdoElementGeneralWriterRepository */
    protected $elementGeneralWriterRepository;

    public function testIfPersistIsValidThenReturnValidResponse(): void
    {
        $this->elementGeneralWriterRepository = new MysqlPdoElementGeneralWriterRepository(
            $this->mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete()
        );

        $elementGeneral = ElementGeneralMother::random();

        $result = $this
            ->elementGeneralWriterRepository
            ->persist($elementGeneral);

        $this->assertTrue($result);
    }

    public function testIfPersistThrowsException(): void
    {
        $this->expectException(ElementGeneralPersistException::class);

        $this->elementGeneralWriterRepository = new MysqlPdoElementGeneralWriterRepository(
            $this->mockPDOThrowException()
        );

        $elementGeneral = ElementGeneralMother::random();

        $this
            ->elementGeneralWriterRepository
            ->persist($elementGeneral);
    }
}
