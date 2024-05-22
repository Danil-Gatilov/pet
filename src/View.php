<?php


namespace App;


use App\session\Session;

class View
{

    public function __construct(
        public Session $session
    ) {
    }

    public function view(string $name, array $dataForView = []): void
    {
        extract(array_merge($this->extractData(), $dataForView));

        $name = strtok($name, '?');

        require_once APP_PATH . "/views/$name.php";

    }

    public function component(string $name, array $dataForView = []): void
    {
        extract(array_merge($this->extractData(), $dataForView));

        require_once APP_PATH . "/views/components/$name.php";
    }

    public function start(): void
    {
        require_once APP_PATH . "/views/components/start.php";
    }

    public function extractData(): array
    {
        return [
            'view' => $this,
            'session' => $this->session
        ];
    }
}