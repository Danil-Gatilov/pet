<?php

namespace App\http;
use App\validator\validator;

class Request
{
    private validator $validator;

    public function __construct(
        private array $get,
        private array $post,
        private array $server,
        private array $files,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES);
    }

    public function setValidator(validator $validator): void
    {
        $this->validator = $validator;
    }


    public function validate(array $rules): bool
    {
        $data = [];

        foreach ($rules as $field => $fieldRules) {
            if ($this->input($field)) {
                $data[$field] = $this->input($field);
            }
        }

        return $this->validator->validate($data, $rules);
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }

    public function input(string $field): ?string
    {
        return $this->post[$field] ?? $this->get[$field] ?? null;
    }

    /**
     * @return array
     */
    public function post(string $parameter): array
    {
        return $this->post[$parameter];
    }

    /**
     * @return array
     */
    public function get(string $parameter): mixed
    {
        return $this->get[$parameter];
    }

    public function GET_check(string $parameter): bool
    {
        return (isset($this->get[$parameter]));
    }

    /**
     * @return array
     */
    public function files(string $file): mixed
    {
        return $this->files[$file];
    }

    /**
     * @return array
     */
    public function server(string $parameter): mixed
    {
        return $this->server[$parameter];
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }
}