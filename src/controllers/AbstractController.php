<?php

namespace App\controllers;

use App\database\Database;
use App\http\Redirect;
use App\http\Request;
use App\middleware\AuthMiddleware;
use App\middleware\GuestMiddleware;
use App\session\Session;
use App\validator\validator;
use App\View;
use Twig\Environment;

abstract class AbstractController
{
    public View $viewOld;
    public Environment $view;
    public Database $database;
    public Request $request;
    public Redirect $redirect;
    public Session $session;
    public AuthMiddleware $user;
    public GuestMiddleware $guest;



    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
        $this->viewOld = new View($this->session);
        $twigLoader = new \Twig\Loader\FilesystemLoader(APP_PATH . '/views');
        $this->view = new \Twig\Environment($twigLoader);

        $this->database = new Database();
        $this->redirect = new Redirect();
        $this->guest = new GuestMiddleware($this->session, $this->redirect);
        $this->user = new AuthMiddleware($this->session, $this->redirect);

    }

    public function view(string $name, array $dataForView = []): void
    {
        $this->viewOld->view($name, $dataForView);
    }

}