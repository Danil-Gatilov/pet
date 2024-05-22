<?php


namespace App\http;


class Redirect
{
    public function to(string $page): void
    {
        header("location: $page");
    }
}