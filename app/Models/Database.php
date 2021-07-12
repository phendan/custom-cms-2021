<?php

class Database {
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $dbName = '';

    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host={$this->host};dbName={$this->dbName}",
            $this->username,
            $this->password
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
