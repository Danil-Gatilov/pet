<?php

namespace App\controllers;

use App\http\Request;
use App\models\diary;
use App\session\Session;

class DiaryController extends AbstractController
{
    private diary $diary;

    public function __construct(Session $session, Request $request)
    {
        parent::__construct($session, $request);
        $this->diary = new diary($this->database);
    }

    public function index()
    {
        $this->view('diary', ['diary' => $this->diary]);
    }


    public function store()
    {
        $id = $this->diary->insert($this->request->input('text'));

        $this->redirect->to('/blog/diary');
    }
}