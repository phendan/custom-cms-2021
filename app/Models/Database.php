<?php

namespace App\Models;

use PDO;
use Exception;

class Database {
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $dbName = '';

    private $pdo;
    private $table;
    private $statement;

    public function __construct()
    {
        // try {
        //     $this->pdo = new PDO(
        //         "mysql:host={$this->host};dbName={$this->dbName}",
        //         $this->username,
        //         $this->password
        //     );
        //     $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // } catch (Exception $e) {
        //     die($e->getMessage());
        // }
    }

    public function table(string $table)
    {
        $this->table = $table;

        return $this;
    }

    public function query(string $sql, array $values = [])
    {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute($values);

        return $this;
    }

    public function where(string $field, string $operator, string|int $value)
    {
        $this->query("SELECT * FROM {$this->table} WHERE {$field} {$operator} ?", [ $value ]);

        return $this;
    }

    public function count()
    {
        return $this->statement->rowCount();
    }

    public function results()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function last()
    {
        return end($this->results());
    }
}
