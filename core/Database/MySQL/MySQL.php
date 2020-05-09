<?php

namespace Core\Database\MySQL;

use Core\Database\DatabaseInterface;

class MySQL implements DatabaseInterface
{
    /**
     * @var \PDO $pdo
     */
    private $pdo;

    /**
     * @var string $table
     */
    private $table;

    /**
     * MySQL constructor.
     */
    public function __construct()
    {
        // todo create a Parameter class and call it with the container
        require __DIR__ . '/../../../config/parameters.php';
        /** @var array $database_parameters */
        $dsn = 'mysql:host=' . $database_parameters['host'] . ';dbname=' . $database_parameters['database'];
        $this->pdo = new \PDO($dsn, $database_parameters['username'], $database_parameters['password']);
    }

    /**
     * @param string $table
     * @return $this|mixed
     */
    public function getTable(string $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function find($id)
    {
        if (!$this->table) {
            throw new \PDOException("The getTable method must be call after the find");
        }

        return $this->pdo->query("SELECT * FROM $this->table WHERE id=$id")->fetch(\PDO::FETCH_ASSOC);
    }

    public function findBy(array $parameters)
    {
        // TODO: Implement findBy() method.
    }
}
