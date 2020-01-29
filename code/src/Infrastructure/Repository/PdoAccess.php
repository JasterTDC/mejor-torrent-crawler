<?php

namespace BestThor\ScrappingMaster\Infrastructure\Repository;

/**
 * Class PdoAccess
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Repository
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class PdoAccess
{
    /**
     * @var string
     */
    protected $dsn;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * PdoWriter constructor.
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     */
    public function __construct(
        string $dsn,
        string $username,
        string $password
    ) {
        $this->pdo = new \PDO($dsn, $username, $password);

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
