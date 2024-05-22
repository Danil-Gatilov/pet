<?php


namespace App\database;


class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function insert(string $table, array $data): int
    {
        $fields = implode(', ', array_keys($data));

        $values = implode(', ', array_map(fn($field) => ":$field", array_keys($data)));

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function get(string $table, array $conditions = []): array
    {
        if (! empty($conditions)) {
            $fields = implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
            $sql = "SELECT * FROM $table WHERE $fields";
        } else {
            $sql = "SELECT * FROM $table";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
//UPDATE table SET column1 = value1, col2 = val2, ... WHERE conditions
    public function patch(string $table, array $data, array $conditions): void
    {
        $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));

        $set = implode(', ', array_map(fn($field) => "$field = :$field", array_keys($data)));

        $sql = "UPDATE $table SET $set $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array_merge($data, $conditions));
    }

    public function delete(string $table, array $conditions): void
    {
        $fields = implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));

        $sql = "DELETE FROM $table WHERE $fields";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);
    }

    public function checkUser(array $conditions): array|false
    {
        $fields = implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));

        $sql = "SELECT * FROM users WHERE $fields LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    private function connect(): void
    {
        $config = require_once APP_PATH . '/config/database.php';

        $driver = $config['driver'];
        $host = $config['host'];
        $port = $config['port'];
        $charset = $config['charset'];
        $user = $config['user'];
        $password = $config['password'];
        $dbName = $config['dbname'];

        try {
            $this->pdo = new \PDO("$driver:host=$host;port=$port;charset=$charset;dbname=$dbName", $user, $password);
        } catch (\PDOException $exception){
            echo $exception->getMessage();
        }
    }


}