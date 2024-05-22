<?php

namespace App\controllers;

use App\http\Request;
use App\models\Book;
use App\session\Session;
use App\Storage;

class LibraryController extends AbstractController
{
    private Book $book;
    private Storage $storage;

    public function __construct(Session $session, Request $request)
    {
        parent::__construct($session, $request);
        $this->book = new Book($this->database);
        $this->storage = new Storage($this->request);
    }

    public function index()
    {
        $this->view('library', ['books' => $this->book]);
    }

    public function store()
    {
        $this->storage->addToStorage();
        $this->book->insert($this->request->input('bookName'));
        $this->redirect->to('library');
    }

    public function read()
    {
        $bookName = $this->request->input('bookName');

        $filePath = APP_PATH . "/storage/$bookName.pdf";

        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename=\"{$bookName}.pdf\""); // Указываем имя файла, которое будет отображаться в браузере

// Открываем файл и выводим его содержимое в браузер
        readfile($filePath);
    }

    public function delete(): void
    {
        $book = $this->request->input('bookName');

        $this->book->delete([
            'bookName' => $book
        ]);
        unlink(APP_PATH . "/storage/$book.pdf");

        $this->redirect->to('library');
    }

}