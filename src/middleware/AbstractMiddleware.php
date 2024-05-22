<?php


namespace App\middleware;


use App\http\Redirect;
use App\session\Session;

abstract class AbstractMiddleware
{
    public function __construct(
        protected Session $session,
        protected Redirect $redirect
    ) {
    }

    abstract public function check(): void;
}