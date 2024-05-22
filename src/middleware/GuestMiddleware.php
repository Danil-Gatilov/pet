<?php


namespace App\middleware;


class GuestMiddleware extends AbstractMiddleware
{
    public function check(): void
    {
        if (! $this->session->has('nickName')) {
            $this->redirect->to('auth');
        }
    }
}