<?php

const HOST = 'localhost';
const DB_NAME = 'team_malhas';
const USER = 'postgres';
const PASSWORD = '123';

class Connect
{
    protected $connection;

    public function __construct()
    {
        $this->connectDatabase();
    }

    public function connectDatabase(): void
    {
        try {
            $this->connection = new PDO('pgsql:host=' . HOST . ';dbname=' . DB_NAME, USER, PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->connection->query('SELECT 1');
            $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error!" . $e->getMessage();
            die();
        }
    }
}
