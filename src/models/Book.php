<?php


namespace App\models;


use App\database\Database;

class Book
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        return $this->database->get('books');
    }

    public function insert(string $bookName): int
    {
        return $this->database->insert('books', ['bookName' => $bookName]);
    }



    public function delete(array $conditions): void
    {
        $this->database->delete('books', $conditions);
    }
}