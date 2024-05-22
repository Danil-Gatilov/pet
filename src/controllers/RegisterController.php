<?php


namespace App\controllers;


class RegisterController extends AbstractController
{
    public function register()
    {
        $this->view('register');
    }


    public function add()
    {
        $validate = $this->request->validate([
            'firstName' => ['required', 'min:2',],
            'lastName' => ['required', 'min:2'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:10']
        ]);

        if (! $validate) {
            foreach ($this->request->errors() as $field => $errors) {
                $this->session->set($field, $errors);

                $this->checkValue();

            }
            $this->redirect->to('/register');
        } else {
            $id = $this->database->insert('users', [
                'firstName' => $this->request->input('firstName'),
                'lastName' => $this->request->input('lastName'),
                'email' => $this->request->input('email'),
                'password' => password_hash($this->request->input('password'), PASSWORD_DEFAULT),
            ]);
            $this->session->set('nickName', $this->request->input('firstName') . ' ' . $this->request->input('lastName'));
            //self::$session->set('lastName', $this->request->input('lastName'));
        $this->redirect->to('home');
        }

    }

    private function checkValue(): void
    {
        if (!$this->session->get('firstName')) {
            $this->session->set('firstName', $this->request->input('firstName'));
        }
        if (!$this->session->get('lastName')) {
            $this->session->set('lastName', $this->request->input('lastName'));
        }
        if (!$this->session->get('email')) {
            $this->session->set('email', $this->request->input('email'));
        }
        if (!$this->session->get('password')) {
            $this->session->set('password', $this->request->input('password'));
        }
    }
}