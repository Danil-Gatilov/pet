<?php


namespace App\middleware;


use App\session\Session;

class AuthMiddleware extends AbstractMiddleware
{

    public function check(): void
    {
        if ($this->session->has('nickName')) {
            $this->redirect->to('home');
        }
    }
}