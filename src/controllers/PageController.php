<?php


namespace App\controllers;


use App\http\Request;
use App\models\diary;
use App\session\Session;

class PageController extends AbstractController
{
    private diary $diary;

    public function __construct(Session $session, Request $request)
    {
        parent::__construct($session, $request);
        $this->diary = new diary($this->database);
    }

    public function index()
    {
        $date = $this->request->input('created_at');
        $page = $this->diary->get(['created_at' => $date]);

        $this->view('page', ['page' => $page, 'diary' => $this->diary]);
    }

    public function edit()
    {
        $date = $this->request->input('created_at');
        $pageInfo = $this->diary->get([
            'created_at' => $date
        ]);

        $this->view('edit', ['page' => $pageInfo, 'diary' => $this->diary]);
    }

    public function patch()
    {
        $text = $this->request->input('text');

        $createdAT = $this->request->input('created_at');

        $this->diary->patch(['text' => $text], ['created_at' => $createdAT]);

        $this->index();
    }

    public function delete(): void
    {
        $this->diary->delete(['created_at' => $this->request->input('created_at')]);

        $this->redirect->to('diary');
    }
}