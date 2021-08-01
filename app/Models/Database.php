<?php

namespace App\Models;

use App\Config;
use PDO;
use Exception;

class Database {
    private $pdo;
    private $table;
    private $joinTable;
    private $statement;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . Config::get('database.host') . ';dbname=' . Config::get('database.dbName'),
                Config::get('database.username'),
                Config::get('database.password')
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
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

    public function join(string $table)
    {
        $this->joinTable = $table;
    }

    public function on(array|string ...$columns)
    {
        if (is_array($columns[0])) $columns = $columns[0];
        $this->joinColumns = $columns;
    }

    public function where(string $field, string $operator, string|int $value)
    {
        if (!isset($this->joinTable)) {
            $this->query("SELECT * FROM {$this->table} WHERE {$field} {$operator} ?", [ $value ]);
            return $this;
        }

        [$leftColumn, $rightColumn] = $this->joinColumns;
        $this->query("
            SELECT * FROM {$this->table}
            LEFT JOIN {$this->joinTable}
            ON {$this->table}.{$leftColumn} = ${$this->joinTable}.${$rightColumn}
            WHERE {$field} {$operator} ?
        ", [ $value ]);

        return $this;
    }

    public function getAll()
    {
        $this->query("SELECT * FROM {$this->table}");

        return $this->results();
    }

    // Enables insertion as associative array -> ['field_in_table' => 'value']
    public function store(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?,', count($data)), ',');
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES({$placeholders})";
        $this->query($sql, $values);
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
        $results = $this->results();
        return end($results);
    }
}
