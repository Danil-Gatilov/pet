<?php


namespace App\controllers;


use App\http\Request;

class AuthController extends AbstractController
{
    public function logout()
    {
        $this->session->remove('nickName');
        $this->redirect->to('auth');
    }

    public function index(): void
    {
        $this->view('auth');
    }


    public function auth()
    {
        $result = $this->database->checkUser([
            'email' => $this->request->input('email'),
        ]);

        if (! $result) {
            $this->redirect->to('/auth');
            $this->session->set('false', 'неверно указан логин или пароль');
        }

        if (password_verify($this->request->input('password'), $result['password'])){
            $this->session->set('nickName', $result['firstName'] . ' ' . $result['lastName']);
            $this->redirect->to('home');
        }
    }
}