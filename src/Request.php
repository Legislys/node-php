<?php

declare(strict_types=1);

namespace App;

class Request
{
    private array $get = [];
    private array $post = [];
    private array $server = [];

    public function __construct(array $get, array $post, array $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public function requestMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getParams(string $method, $defualt = null)
    {
        return $this->$method ?? $defualt;
    }

    public function hasPost(): bool
    {
        return !empty($this->post);
    }
}
