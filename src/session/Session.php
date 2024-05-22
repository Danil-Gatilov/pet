<?php


namespace App\session;


class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function getRemove(string $key): mixed
    {
        $data = $_SESSION[$key];
        $this->remove($key);

        return $data;
    }

    public function checkValue(string $key): bool
    {
        if (isset($_SESSION[$key]) && is_string($_SESSION[$key])) {
            return true;
        }
        return false;
    }

    public function getValue(string $key)
    {
        if (is_string($_SESSION[$key])) {
            $this->getRemove($key);
        }
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset ($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }
}