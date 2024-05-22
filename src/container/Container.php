<?php

namespace App\container;
use App\http\Redirect;
use App\http\Request;
use App\middleware\AbstractMiddleware;
use App\middleware\AuthMiddleware;
use App\middleware\GuestMiddleware;
use App\router\Router;
use App\session\Session;
use App\validator\validator;

class Container
{
    public Router $router;
    public Request $request;
    public validator $validator;
    public Session $session;
    public Redirect $redirect;


    public function __construct()
    {
        $this->validator = new validator();
        $this->request = Request::createFromGlobals();
        $this->request->setValidator($this->validator);
        $this->session = new Session();
        $this->redirect = new Redirect();

        $this->router = new Router($this->request, $this->session, $this->redirect);

    }
}