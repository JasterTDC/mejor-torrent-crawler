<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use BestThor\ScrappingMaster\Tests\Domain\MotherCreator;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use PDOException;

/**
 * Class PDOMockUtilsTestCase
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
class PDOMockUtilsTestCase extends TestCase
{
    /**
     * @param int $rowCount
     * @return PdoAccess
     */
    protected function mockPDOExecuteAtLeastOnceAnInsertUpdateOrDelete(
        int $rowCount = 0
    ): PdoAccess {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement
            ->method('rowCount')
            ->willReturn($rowCount);

        $mockStatement->expects(
            $this->atLeastOnce()
        )
            ->method('execute')
            ->willReturn(true);

        $mockStatement->expects(
            $this->never()
        )->method('errorInfo');

        return $this->mockSimplePDO($mockStatement);
    }

    /**
     * @param array $dataSet
     *
     * @return PdoAccess
     */
    protected function mockPDOExecuteOnceASelectAndReturnsEmpty(): PdoAccess
    {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->expects(
            $this->once()
        )
            ->method('execute')
            ->willReturn(false);

        return $this->mockSimplePDO($mockStatement);
    }

    /**
     * @param array $dataSet
     *
     * @return PdoAccess
     */
    protected function mockPDOExecuteOnceASelectAndFetchEmpty(): PdoAccess
    {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->expects(
            $this->once()
        )
            ->method('execute')
            ->willReturn(true);

        $mockStatement
            ->method('fetchAll')
            ->willReturn(false);

        $mockStatement
            ->method('fetch')
            ->willReturn(false);

        return $this->mockSimplePDO($mockStatement);
    }

    /**
     * @param array $dataSet
     * @param bool $executeOne
     *
     * @return PdoAccess
     */
    protected function mockPDOExecuteOnceASelectAndReturnRows(
        array $dataSet,
        bool $executeOne = true
    ): PdoAccess {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement
            ->method('bindValue')
            ->willReturn(true);

        $mockStatement
            ->method('fetchAll')
            ->willReturn($dataSet);

        $mockStatement
            ->method('fetch')
            ->willReturn($dataSet);

        $mockStatement
            ->method('rowCount')
            ->willReturn(count($dataSet));

        $mockStatement
            ->method('fetchColumn')
            ->willReturn(count($dataSet));

        $mockStatement->expects(
            $this->never()
        )->method('errorInfo');

        if ($executeOne === true) {
            $mockStatement->expects(
                $this->once()
            )
                ->method('execute')
                ->willReturn(true);
        }

        if ($executeOne === false) {
            $mockStatement
                ->method('execute')
                ->willReturn(true);
        }

        return $this->mockSimplePDO($mockStatement);
    }

    /**
     * @return PdoAccess
     */
    protected function mockPDOThrowException(): PdoAccess
    {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement
            ->method('execute')
            ->will($this->throwException(new PDOException()));

        return $this->mockSimplePDO($mockStatement);
    }

    /**
     * @param PDOStatement $statement
     *
     * @return PdoAccess
     */
    protected function mockSimplePDO(PDOStatement $statement): PdoAccess
    {
        $mock = $this->createMock(PdoAccess::class);

        $mockPdo = $this->createMock(PDO::class);

        $mockPdo
            ->method('prepare')
            ->willReturn($statement);

        $mockPdo
            ->method('lastInsertId')
            ->willReturn(MotherCreator::random()->numberBetween(1));

        $mock
            ->method('getPdo')
            ->willReturn($mockPdo);

        return $mock;
    }
}
