<?php


namespace App\models;


use App\database\Database;

class diary
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        return $this->database->get('posts');
    }

    public function get(array $conditions): array
    {
        return $this->database->get('posts', $conditions);
    }

    public function insert(string $text): int
    {
        return $this->database->insert('posts', ['text' => $text]);
    }

    public function delete(array $conditions): void
    {
        $this->database->delete('posts', $conditions);
    }

    public function patch(array $data, array $conditions): void
    {
        $this->database->patch('posts', $data, $conditions);
    }
}