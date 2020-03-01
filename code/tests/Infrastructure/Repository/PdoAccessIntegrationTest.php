<?php

namespace BestThor\ScrappingMaster\Tests\Infrastructure\Repository;

use BestThor\ScrappingMaster\Infrastructure\Repository\PdoAccess;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Class PdoAccessTest
 *
 * @package BestThor\ScrappingMaster\Tests\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class PdoAccessIntegrationTest extends TestCase
{
    public function testIfPdoIsCreatedSuccessfully(): void
    {
        $readerHost = 'sql';
        $readerPort = 3306;
        $readerDatabase = 'elements';

        $readerUsername = 'root';
        $readerPassword = 'root';

        $dsn = "mysql:host={$readerHost};charset=utf8;port={$readerPort};database={$readerDatabase}";

        $pdoAccess = new PdoAccess(
            $dsn,
            $readerUsername,
            $readerPassword
        );

        $this->assertInstanceOf(PDO::class, $pdoAccess->getPdo());
    }
}
